<?php

namespace JustField {
   class DB
   {
      function __construct($orm, $glo = [])
      {
         $this->orm = clone $orm;
         $this->orm->from('db');

         $this->glo = $glo;
      }

      function get_root()
      {
         return new DBItem($this->orm, '1', $this->glo, '');
      }

      function get_item_data($id)
      {
         return new DBItem($this->orm, $id, $this->glo, '');
      }

      function at_path($path)
      {
         $root = $this->get_root();

         if (!$path) return $root;

         return $root->at_path($path);
      }

      function at_id($id)
      {
         return new DBItem($this->orm, $id, $this->glo, '');
      }
   };
};
