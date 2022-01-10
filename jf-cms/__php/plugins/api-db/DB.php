<?php

namespace JustField {

   $reg->DB = new \stdClass();
   $reg->DB->type = [];

   class DB
   {
      function __construct($orm)
      {
         $this->orm = clone $orm;
         $this->orm->from('db');
      }

      function get_root()
      {
         return new DBItem($this->orm, '1', '');
      }

      function at_path(string $path)
      {
         $root = $this->get_root();

         if (!$path) return $root;

         return $root->at_path($path);
      }

      function at_id($id)
      {
         return new DBItem($this->orm, $id, '');
      }

      function move_field($field_id, $target_parent_id) {
         // creating DBItems
         $field = new DBItem($this->orm, $field_id);
         $target_parent = new DBItem($this->orm, $target_parent_id);

         // moving field using DBItem API
         $field->move_to($target_parent);

         return $field;
      }

      function type_id($name) {
         $table_name_begin = $this->orm->table_name_raw;
         $this->orm->from('type');

         $res = $this->orm->select('id_type')->where("`type_name` = '$name'")();

         $ret = null;
         if ($res)
            $ret = $res[0]['id_type'];

         $this->orm->from($table_name_begin);

         return $ret;
      }
   };
};
