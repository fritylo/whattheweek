<?php

namespace JustField {
   $assets_folder = '../__assets/';

   function ends_with($haystack, $needle) {
      $length = strlen($needle);
      if (!$length) {
         return true;
      }
      return substr($haystack, -$length) === $needle;
   }
   class UploadException extends \Exception {
      public function __construct($code) {
         $message = $this->codeToMessage($code);
         parent::__construct($message, $code);
      }

      private function codeToMessage($code) {
         switch ($code) {
            case UPLOAD_ERR_INI_SIZE:
               $message = "The uploaded file exceeds the upload_max_filesize directive in php.ini";
               break;
            case UPLOAD_ERR_FORM_SIZE:
               $message = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form";
               break;
            case UPLOAD_ERR_PARTIAL:
               $message = "The uploaded file was only partially uploaded";
               break;
            case UPLOAD_ERR_NO_FILE:
               $message = "No file was uploaded";
               break;
            case UPLOAD_ERR_NO_TMP_DIR:
               $message = "Missing a temporary folder";
               break;
            case UPLOAD_ERR_CANT_WRITE:
               $message = "Failed to write file to disk";
               break;
            case UPLOAD_ERR_EXTENSION:
               $message = "File upload stopped by extension";
               break;

            default:
               $message = "Unknown upload error with code '$code'";
               break;
         }
         return $message;
      }
   }
   class T_image {
      function __construct($orm) {
         $this->orm = clone $orm;
         $this->type_table_orm = clone $orm;

         $ends_with_T = ends_with($this->orm->table_prefix, 'T_');
         if (!$ends_with_T)
            $this->type_table_orm->table_prefix .= 'T_';

         $this->type_table_orm->table('image');

         $this->id = null;
      }

      function set_id($id) {
         $type_table_id = $this->orm->select('`db-item_value`')->where("`id_db-item` = '$id'")()[0]['db-item_value'];
         $this->id = $type_table_id;
      }

      function create() {
         $this->type_table_orm->insert([
            'id_image' => null,
            'image_src' => '',
         ])();

         $id = $this->type_table_orm->select('MAX(`id_image`) as max_id')()[0]['max_id'];
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
         $target_name = "{$this->id}.{$ext}";
         $target_file = $reg->path_to_jf_php_folder . "$assets_folder$target_name"; // assets_folder has '/' at end

         move_uploaded_file($value['tmp_name'], $target_file);
         chmod($target_file, 0777);

         $this->type_table_orm->update(['image_src' => $target_name])->where("`id_image` = '{$this->id}'")();
         return $target_file;
      }

      function duplicate_value_to(DBItem $field, DBItem $new_field) {
         global $assets_folder, $reg;

         $image_value = $field->value;
         $image_src = strpos($image_value->src, '?') ? strtok($image_value->src, '?') : $image_value->src;
         $image_name = $image_value->name;

         $ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
         $target_name = "{$new_field->value_id}.{$ext}";
         $target_file = $reg->path_to_jf_php_folder . "$assets_folder$target_name"; // assets folder already have '/' at end

         if (file_exists($image_src)) {
            file_put_contents($target_file, file_get_contents($image_src)); // copy file contents to new field file
            chmod($target_file, 0777);

            $this->type_table_orm->update(['image_src' => $target_name])->where("`id_image` = '{$new_field->value_id}'")();
         }

         return $target_file;
      }

      function get_value() {
         global $assets_folder, $reg;

         $src = $this->type_table_orm->select('`image_src`')->where("`id_image` = '{$this->id}'")()[0]['image_src'];
         $date_now = time();

         $ret = new \stdClass();
         $ret->name = $src;
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

      static function render_value(DBItem $child) { ?>
         <div class="row">
            <?php if ($child->value->src) : ?>
               <div class="item_T_image__thumbnail row jcc aic"><img src="<?= $child->value->src ?>">
               </div>
               <button class="box p1 box_mode_dark button tal cup brad0 item_T_image__show-button" data-mfp-src="<?= $child->value->src ?>">Show
               </button>
            <?php else : ?>
               <div class="item_T_image__thumbnail item_T_image__thumbnail_free row jcc aic"><img class="dn" src=""></div>
               <button class="box p1 box_mode_dark button tal cup brad0 item_T_image__show-button" data-mfp-src="" disabled="disabled">Show
               </button>
            <?php endif; ?>
            <button class="box p1 box_mode_dark button tal cup brad0 item_T_image__upload-button">Upload
            </button>
            <form class="dn item_T_image__file-form">
               <input class="item_T_image__file" type="file" name="image" accept="image/*">
            </form>
         </div>
      <?php }

      static function render_value_template() { ?>
         <div class="row">
            <div class="item_T_image__thumbnail item_T_image__thumbnail_free row jcc aic"><img class="dn" src=""></div>
            <button class="box p1 box_mode_dark button tal cup brad0 item_T_image__show-button" href="{value}" disabled="disabled">Show
            </button>
            <button class="box p1 box_mode_dark button tal cup brad0 item_T_image__upload-button">Upload
            </button>
            <form class="dn item_T_image__file-form">
               <input class="item_T_image__file" type="file" name="image" accept="image/*">
            </form>
         </div>
      <?php }

      static function render_addictive_templates() {
      }
   }

   $reg->DB->type['image'] = 'JustField\T_image';
}
