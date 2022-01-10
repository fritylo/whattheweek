<?php
namespace JustField {
   $assets_folder = '../__assets/';

   class T_excel {
      function __construct($orm) {
         $this->orm = clone $orm;
         $this->type_table_orm = clone $orm;

         $ends_with_T = ends_with($this->orm->table_prefix, 'T_');
         if (!$ends_with_T)
            $this->type_table_orm->table_prefix .= 'T_';

         $this->type_table_orm->table('excel');

         $this->id = null;
      }

      function set_id($id) {
         $type_table_id = $this->orm->select('`db-item_value`')->where("`id_db-item` = '$id'")()[0]['db-item_value'];
         $this->id = $type_table_id;
      }

      function create() {
         $this->type_table_orm->insert([
            'id_excel' => null,
            'excel_src' => '',
         ])();

         $id = $this->type_table_orm->select('MAX(`id_excel`) as max_id')()[0]['max_id'];
         $this->id = $id;
         return $id;
      }

      function update(DBItem $item, $value) {
         $value = $value['_FILES'];
         global $assets_folder, $reg;

         if ($value['error'] != UPLOAD_ERR_OK) 
            throw new UploadException($value['error']);

         $old_file = $this->get_value()->src;
         if (file_exists($old_file)) unlink($old_file);

         $ext = strtolower(pathinfo($value['name'], PATHINFO_EXTENSION));
         $target_name = "excel{$this->id}.{$ext}";
         $target_file = $reg->path_to_jf_php_folder . "$assets_folder$target_name"; // assets_folder has '/' at end

         move_uploaded_file($value['tmp_name'], $target_file);
         chmod($target_file, 0777);

         $this->type_table_orm->update(['excel_src' => $target_name])->where("`id_excel` = '{$this->id}'")();
         return $target_file;
      }

      function duplicate_value_to(DBItem $field, DBItem $new_field) {
         global $assets_folder, $reg;

         $file_value = $field->value;
         $file_src = strpos($file_value->src, '?') ? strtok($file_value->src, '?') : $file_value->src;
         $file_name = $file_value->name;

         $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
         $target_name = "excel{$new_field->value_id}.{$ext}";
         $target_file = $reg->path_to_jf_php_folder . "$assets_folder$target_name"; // assets folder already have '/' at end

         if (file_exists($file_src)) {
            file_put_contents($target_file, file_get_contents($file_src)); // copy file contents to new field file
            chmod($target_file, 0777);

            $this->type_table_orm->update(['excel_src' => $target_name])->where("`id_excel` = '{$new_field->value_id}'")();
         }

         return $target_file;
      }

      function get_value() {
         global $assets_folder, $reg;

         $src = $this->type_table_orm->select('`excel_src`')->where("`id_excel` = '{$this->id}'")()[0]['excel_src'];

         $ret = new \stdClass();
         $ret->name = $src;
         $date_now = time();
         $ret->src = $src ? $reg->path_to_jf_php_folder . $assets_folder . $src . "?t=$date_now" : '';

         return $ret;
      }

      function remove(DBItem $item) {
         $old_file = $item->value->src;
         if (file_exists($old_file)) unlink($old_file);

         $this->type_table_orm->delete()->where_id($this->id)();
      }

      function to_string($item_value) {
         return $item_value->src;
      }

      static function on_refresh(&$api, DBItem &$item) {
         global $assets_folder;
         $api->get_html = function () use ($item, $assets_folder) {
            require_once __DIR__ . '/vendor/autoload.php';

            $inputFileName = __DIR__ . '/../../' . $assets_folder . $item->value->name;

            /**  Identify the type of $inputFileName  **/
            $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);
            /**  Create a new Reader of the type that has been identified  **/
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
            /**  Load $inputFileName to a Spreadsheet Object  **/
            $spreadsheet = $reader->load($inputFileName);
            $sheet_names = $spreadsheet->getSheetNames();

            $sheetCount = $spreadsheet->getSheetCount();
            if (!$sheetCount) return '';

            $res = '';
            $sheet_buttons = '<div class="table-sheet-buttons">';

            for ($i = 0; $i < $sheetCount; $i++) {
               $sheetObject = $spreadsheet->getSheet($i);
               $sheet = $sheetObject->toArray(null, true, true, true);

               $sheet_name = $sheet_names[$i];
               $sheet_buttons .= '<button class="table-sheet-button '.($i == 0 ? 'table-sheet-button_current' : '').'" data-id="'.$i.'" style="'.($i == 0 ? 'font-weight: bold;' : '').'">'.$sheet_name.'</button>';

               $res .= '<div class="table-sheet" data-id="'.$i.'" style="'.($i > 0 ? 'display: none;' : '').'" '.($i == 0 ? 'data-is-current=""' : '').'><table><thead><tr>';
               foreach ($sheet[1] as $cell_col => $cell_value)
                  $res .= "<td>$cell_col</td>";
               $res .= '</tr></thead>';

               $res .= '<tbody>';
               $row_i = 1;
               foreach ($sheet as $row) {
                  $res .= '<tr><td>'.$row_i.'</td>';
                  foreach ($row as $cell_col => $cell_value) {
                     $res .= '<td>'.$cell_value.'</td>';
                  }
                  $res .= '</tr>';
                  $row_i++;
               }
               $res .= '</tbody></table></div>';
            }

            $sheet_buttons .= '</div>';
            $res = $sheet_buttons . $res;
            $res .= '<script>document.querySelectorAll(\'.table-sheet-button\').forEach(button => button.addEventListener(\'click\', function (e) { 
               var oldSheet = document.querySelector(`.table-sheet[data-is-current=\'\']`);
               var oldButton = document.querySelector(`.table-sheet-button_current`);
               if (oldSheet) {
                  oldSheet.removeAttribute(\'data-is-current\');
                  oldSheet.style.display = \'none\';
                  oldButton.style.fontWeight = \'\';
                  oldButton.classList.remove(\'table-sheet-button_current\');
               }
               var targetSheet = document.querySelector(`.table-sheet[data-id=\'${e.currentTarget.dataset.id}\']`);
               var targetButton = e.currentTarget;
               targetSheet.style.display = \'\';
               targetSheet.setAttribute(\'data-is-current\', \'\');
               targetButton.style.fontWeight = \'bold\';
               targetButton.classList.add(\'table-sheet-button_current\');
            }));</script>';

            return $res;
         };
      }

      static function render_value(DBItem $child) { ?>
         <div class="row">
            <?php if ($child->value->src) : ?>
               <button class="box p1 box_mode_dark button tal cup brad0 item_T_excel__download-button">
                  <a href="<?= $child->value->src ?>" download="">
                     Download
                  </a>
               </button>
            <?php else : ?>
               <button class="box p1 box_mode_dark button tal cup brad0 item_T_excel__download-button" disabled="disabled">
                  <a href="" download="">
                     Download
                  </a>
               </button>
            <?php endif; ?>
            <button class="box p1 box_mode_dark button tal cup brad0 item_T_excel__upload-button">
               Upload
            </button>
            <form class="dn item_T_excel__file-form">
               <input class="item_T_excel__file" type="file" name="file" accept=".xls,.xlsx,.xml,.ods,.slk,.gnumeric,.csv" />
            </form>
         </div>
      <?php }

      static function render_value_template() { ?>
         <div class="row">
            <button class="box p1 box_mode_dark button tal cup brad0 item_T_excel__download-button" disabled="disabled">
               <a href="{value}" download="">
                  Download
               </a>
            </button>
            <button class="box p1 box_mode_dark button tal cup brad0 item_T_excel__upload-button">
               Upload
            </button>
            <form class="dn item_T_excel__file-form">
               <input class="item_T_excel__file" type="file" name="file" accept=".xls,.xlsx,.xml,.ods,.slk,.gnumeric,.csv" />
            </form>
         </div>
      <?php }

      static function render_addictive_templates() {

      }
      
   }

   $reg->DB->type['excel'] = 'JustField\T_excel';
}