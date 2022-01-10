<?php

namespace JustField {
   $assets_folder = '../__assets/';

   class T_video {
      function __construct($orm) {
         $this->orm = clone $orm;
         $this->type_table_orm = clone $orm;

         $ends_with_T = ends_with($this->orm->table_prefix, 'T_');
         if (!$ends_with_T)
            $this->type_table_orm->table_prefix .= 'T_';

         $this->type_table_orm->table('video');

         $this->id = null;
      }

      function set_id($id) {
         $type_table_id = $this->orm->select('`db-item_value`')->where("`id_db-item` = '$id'")()[0]['db-item_value'];
         $this->id = $type_table_id;
      }

      function create() {
         $this->type_table_orm->insert([
            'id_video' => null,
            'video_src' => '',
         ])();

         $id = $this->type_table_orm->select('MAX(`id_video`) as max_id')()[0]['max_id'];
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
         $target_name = "v{$this->id}.{$ext}";
         $target_file = $reg->path_to_jf_php_folder . "$assets_folder$target_name"; // assets_folder has '/' at end

         move_uploaded_file($value['tmp_name'], $target_file);
         chmod($target_file, 0777);

         $this->type_table_orm->update(['video_src' => $target_name])->where("`id_video` = '{$this->id}'")();
         return $target_file;
      }

      function duplicate_value_to(DBItem $field, DBItem $new_field) {
         global $assets_folder, $reg;

         $video_value = $field->value;
         $video_src = strpos($video_value->src, '?') ? strtok($video_value->src, '?') : $video_value->src;
         $video_name = $video_value->name;

         $ext = strtolower(pathinfo($video_name, PATHINFO_EXTENSION));
         $target_name = "v{$new_field->value_id}.{$ext}";
         $target_file = $reg->path_to_jf_php_folder . "$assets_folder$target_name"; // assets folder already have '/' at end

         if (file_exists($video_src)) {
            file_put_contents($target_file, file_get_contents($video_src)); // copy file contents to new field file
            chmod($target_file, 0777);

            $this->type_table_orm->update(['video_src' => $target_name])->where("`id_video` = '{$new_field->value_id}'")();
         }

         return $target_file;
      }

      function get_value() {
         global $assets_folder, $reg;

         $src = $this->type_table_orm->select('`video_src`')->where("`id_video` = '{$this->id}'")()[0]['video_src'];

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
               <div class="item_T_video__thumbnail row jcc aic">
                  <video>
                     <source src="<?= $child->value->src ?>"></source>
                  </video>
               </div>
               <button class="box p1 box_mode_dark button tal cup brad0 item_T_video__show-button" data-mfp-src="<?= $child->value->src ?>">Show
               </button>
            <?php else : ?>
               <div class="item_T_video__thumbnail item_T_video__thumbnail_free row jcc aic">
                  <video class="dn">
                     <source src=""></source>
                  </video>
               </div>
               <button class="box p1 box_mode_dark button tal cup brad0 item_T_video__show-button" data-mfp-src="" disabled="disabled">Show
               </button>
            <?php endif; ?>
            <button class="box p1 box_mode_dark button tal cup brad0 item_T_video__upload-button">Upload
            </button>
            <form class="dn item_T_video__file-form">
               <input class="item_T_video__file" type="file" name="video" accept="video/*">
            </form>
         </div>
      <?php }

      static function render_value_template() { ?>
         <div class="row">
            <div class="item_T_video__thumbnail item_T_video__thumbnail_free row jcc aic">
               <video class="dn">
                  <source src=""></source>
               </video>
            </div>
            <button class="box p1 box_mode_dark button tal cup brad0 item_T_video__show-button" href="{value}" disabled="disabled">Show
            </button>
            <button class="box p1 box_mode_dark button tal cup brad0 item_T_video__upload-button">Upload
            </button>
            <form class="dn item_T_video__file-form">
               <input class="item_T_video__file" type="file" name="video" accept="video/*">
            </form>
         </div>
      <?php }

      static function render_addictive_templates() {
      }
   }

   $reg->DB->type['video'] = 'JustField\T_video';
}
