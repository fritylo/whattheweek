<?php

namespace JustField {
   $assets_folder = '../__assets/';

   class T_audio {
      function __construct($orm) {
         $this->orm = clone $orm;
         $this->type_table_orm = clone $orm;

         $ends_with_T = ends_with($this->orm->table_prefix, 'T_');
         if (!$ends_with_T)
            $this->type_table_orm->table_prefix .= 'T_';

         $this->type_table_orm->table('audio');

         $this->id = null;
      }

      function set_id($id) {
         $type_table_id = $this->orm->select('`db-item_value`')->where("`id_db-item` = '$id'")()[0]['db-item_value'];
         $this->id = $type_table_id;
      }

      function create() {
         $this->type_table_orm->insert([
            'id_audio' => null,
            'audio_src' => '',
         ])();

         $id = $this->type_table_orm->select('MAX(`id_audio`) as max_id')()[0]['max_id'];
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
         $target_name = "a{$this->id}.{$ext}";
         $target_file = $reg->path_to_jf_php_folder . "$assets_folder$target_name"; // assets_folder has '/' at end

         move_uploaded_file($value['tmp_name'], $target_file);
         chmod($target_file, 0777);

         $this->type_table_orm->update(['audio_src' => $target_name])->where("`id_audio` = '{$this->id}'")();
         return $target_file;
      }

      function duplicate_value_to(DBItem $field, DBItem $new_field) {
         global $assets_folder, $reg;

         $file_value = $field->value;
         $file_src = strpos($file_value->src, '?') ? strtok($file_value->src, '?') : $file_value->src;
         $file_name = $file_value->name;

         $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
         $target_name = "a{$new_field->value_id}.{$ext}";
         $target_file = $reg->path_to_jf_php_folder . "$assets_folder$target_name"; // assets folder already have '/' at end

         if (file_exists($file_src)) {
            file_put_contents($target_file, file_get_contents($file_src)); // copy file contents to new field file
            chmod($target_file, 0777);

            $this->type_table_orm->update(['audio_src' => $target_name])->where("`id_audio` = '{$new_field->value_id}'")();
         }

         return $target_file;
      }

      function get_value() {
         global $assets_folder, $reg;

         $src = $this->type_table_orm->select('`audio_src`')->where("`id_audio` = '{$this->id}'")()[0]['audio_src'];

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

      static function render_value(DBItem $child) { ?>
         <div class="row">
            <?php if ($child->value->src) : ?>
               <audio controls>
                  <source src="<?= $child->value->src ?>" />
                  Your browser does not support the audio element.
               </audio>
            <?php else : ?>
               <audio controls>
                  <source src="" />
                  Your browser does not support the audio element.
               </audio>
            <?php endif; ?>
            <button class="box p1 box_mode_dark button tal cup brad0 item_T_audio__upload-button">
               Upload
            </button>
            <form class="dn item_T_audio__file-form">
               <input class="item_T_audio__file" type="file" name="file" accept="audio/*" />
            </form>
         </div>
      <?php }

      static function render_value_template() { ?>
         <div class="row">
            <audio controls>
               <source src="{value}" />
               Your browser does not support the audio element.
            </audio>
            <button class="box p1 box_mode_dark button tal cup brad0 item_T_audio__upload-button">
               Upload
            </button>
            <form class="dn item_T_audio__file-form">
               <input class="item_T_audio__file" type="file" name="file" accept="audio/*" />
            </form>
         </div>
<?php }

      static function render_addictive_templates() {
      }
   }

   $reg->DB->type['audio'] = 'JustField\T_audio';
}
