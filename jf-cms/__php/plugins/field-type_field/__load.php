<?php

namespace JustField {
   class T_field {
      function __construct($orm) {
         $this->orm = clone $orm;
         $this->type_table_orm = clone $orm;

         $this->type_table_orm->table_prefix .= 'T_';
         $this->type_table_orm->table('field');

         $this->value = '';
         $this->id = null;
      }

      function set_id($id) {
         $type_table_id = $this->orm->select('`db-item_value`')->where("`id_db-item` = '$id'")()[0]['db-item_value'];
         $this->id = $type_table_id;
      }

      function create() {
         $this->type_table_orm->insert([
            'id_field' => null,
            'field_value' => '',
         ])();

         $id = $this->type_table_orm->select('MAX(`id_field`) as max_id')()[0]['max_id'];
         $this->id = $id;
         return $id;
      }

      function update(DBItem $item, array $value) {
         $this->type_table_orm->update(['field_value' => $value['value']])->where("`id_field` = '{$this->id}'")();
      }

      function get_value() {
         return $this->type_table_orm->select('field_value')->where("`id_field` = '{$this->id}'")()[0]['field_value'];
      }

      function remove() {
         $this->type_table_orm->delete()->where_id($this->id)();
      }

      function duplicate_value_to(DBItem $field, DBItem $new_field) {
         $new_field->update('value', $field->value);
      }

      function to_string($item_value) {
         return $item_value;
      }

      static function render_value(DBItem $child) { ?>
         <input placeholder="Input value..." value="<?= htmlspecialchars($child->value) ?>">
      <?php }

      static function render_value_template() { ?>
         <input placeholder="Input value..." value="{value}">
      <?php }

      static function render_addictive_templates() {
      }
   }

   $reg->DB->type['field'] = 'JustField\T_field';
}
