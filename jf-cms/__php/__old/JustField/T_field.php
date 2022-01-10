<?php

namespace JustField {
   class T_field
   {
      function __construct($orm)
      {
         $this->orm = clone $orm;
         $this->orm->table_prefix .= 'T_';
         $this->orm->table('field');
         $this->value = '';
         $this->id = null;
      }

      function set_id($id)
      {
         $this->id = $id;
      }

      function create()
      {
         $this->orm->insert([
            'id_field' => null,
            'field_value' => '',
         ])();

         $id = $this->orm->select('MAX(`id_field`) as max_id')()[0]['max_id'];
         $this->id = $id;
         return $id;
      }

      function update($value)
      {
         $this->orm->update(['field_value' => $value])->where("`id_field` = '{$this->id}'")();
      }

      function get_value()
      {
         return $this->orm->select('field_value')->where("`id_field` = '{$this->id}'")()[0]['field_value'];
      }

      function delete()
      {
         $this->orm->delete()->where_id($this->id)();
      }
   }
}
