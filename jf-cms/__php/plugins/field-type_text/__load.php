<?php

namespace JustField {

   require_once __DIR__ . '/deleteDir.php';
   require_once __DIR__ . '/copyDir.php';
   class T_text {
      static private string $assets_folder = '../__assets/T_text/';

      function __construct($orm) {
         $this->orm = clone $orm;
         $this->type_table_orm = clone $orm;

         $this->type_table_orm->table_prefix .= 'T_';
         $this->type_table_orm->table('text');

         $this->value = '';
         $this->id = null;
      }

      function set_id($id) {
         $type_table_id = $this->orm->select('`db-item_value`')->where("`id_db-item` = '$id'")()[0]['db-item_value'];
         $this->id = $type_table_id;
      }

      function create() {
         $this->type_table_orm->insert([
            'id_text' => null,
            'text_value' => '',
            'text_html' => '',
         ])();

         $id = $this->type_table_orm->select('MAX(`id_text`) as max_id')()[0]['max_id'];
         $this->id = $id;

         mkdir(T_text::$assets_folder . $id);
         chmod(T_text::$assets_folder . $id, 0777);

         return $id;
      }

      function update(DBItem $item, array $value) {
         $json = json_decode($value['value']);

         $value_raw = json_encode($json->value);
         $value = htmlentities($value_raw);
         $html = $json->html;

         $this->type_table_orm->update([
            'text_value' => $value,
            'text_html' => $html,
         ])->where("`id_text` = '{$this->id}'")();

         $res = $value_raw;
         $res = str_replace('\"', '&jfescapedquote;', $res);
         $res = str_replace('"', '\"', $res);
         $res = str_replace('&jfescapedquote;', '\"', $res);
         return $res;
      }

      function get_value() {
         global $reg;

         $res = $this->type_table_orm->select('text_value, text_html')->where("`id_text` = '{$this->id}'")()[0];

         $html = $res['text_html'];
         $html = str_replace('../__assets/', $reg->path_to_jf_php_folder . '../__assets/', $html);
         $html = str_replace('..\/__assets\/', $reg->path_to_jf_php_folder . '..\/__assets\/', $html);

         $ret = new \stdClass();
         $ret->value = $res['text_value'];
         $ret->html = $html;

         return $ret;
      }

      function remove() {
         $this->type_table_orm->delete()->where_id($this->id)();
         deleteDir(T_text::$assets_folder . $this->id);
      }

      function duplicate_value_to(DBItem $field, DBItem $new_field) {
         function replace_id($old_string, $old_id, $new_id) {
            $new_string = $old_string;
            $new_string = str_replace("__assets/T_text/$old_id/", "__assets/T_text/$new_id/", $new_string);
            $new_string = str_replace("__assets\\/T_text\\/$old_id\\/", "__assets\\/T_text\\/$new_id\\/", $new_string);
            return $new_string;
         }

         $new_field->update('value', json_encode([
            'value' => json_decode(
               replace_id(
                  html_entity_decode($field->value->value),
                  $field->value_id,
                  $new_field->value_id
               )
            ),
            'html' => replace_id(
               $field->value->html,
               $field->value_id,
               $new_field->value_id
            ),
         ]));

         copyDir(
            T_text::$assets_folder . $field->value_id,
            T_text::$assets_folder . $new_field->value_id
         );
      }

      function to_string($item_value) {
         return $item_value->html;
      }

      static function render_value(DBItem $child) { ?>
         <button class="box p1 box_mode_dark button tal cup brad0 w100" data-value="<?= $child->value->value ?>" data-item-id="<?= $child->id ?>">
            Text editor
         </button>
      <?php }

      static function render_value_template() { ?>
         <button class="box p1 box_mode_dark button tal cup brad0 w100" data-value="{value}" data-item-id="{id}">
            Text editor
         </button>
      <?php }

      static function render_addictive_templates() { ?>
         <template id="template_T_text_editor">
            <div class="item_T_text__editor editor-tabs dn">
               <div class="editor-tabs__controls">
                  <div class="editor-tabs__tabs">
                     <div class="editor-tabs__tab editor-tabs__tab_focused box box_mode_light dn" data-id="{id}">
                        <div class="p1">{title}</div>
                        <div class="editor-tab__close-button box p1" data-tip="Close">
                           <!-- https://www.flaticon.com/packs/user-interface-176--><img src="../__attach/Images/close.png">
                        </div>
                     </div>
                     <div class="editor-tabs__tab editor-tabs__tab_unfocused box box_mode_dark dn" data-id="{id}">
                        <div class="p1">{title}</div>
                        <div class="editor-tab__close-button box p1" data-tip="Close"><img src="../__attach/Images/close-white.png"></div>
                     </div>
                  </div>
                  <div class="editor-tabs__total-buttons">
                     <div class="editor-tabs__colla pse-button box p1 box_mode_light" data-tip="Collapse"><img src="../__attach/Images/collapse.png"></div>
                     <div class="editor-tabs__close-button box p1 box_mode_light" data-tip="Close all editors"><img src="../__attach/Images/close.png"></div>
                  </div>
               </div>
               <div class="editor-tabs__editorjs" id="editorjs"></div>
            </div>
         </template>
      <?php }
   }

   $reg->DB->type['text'] = 'JustField\T_text';
}
