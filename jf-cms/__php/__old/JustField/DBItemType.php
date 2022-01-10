<?php

namespace JustField {
   class DBItemType
   {
      function __construct($orm, $id)
      {
         $orm = clone $orm;
         $data = $orm->from('type')->select('*')->where("id_type = '$id'")();
         if ($data === false) throw new \Exception('No type data in "' . $id . '" in JustField\\DBItemType::__construct');
         $data = $data[0];

         $this->id = $id;
         $this->is_basic = $data['type_is-basic'] == '1' ? true : false;
         $this->name = $data['type_name'];
         if ($data['type_name'] == 'NULL')
            $this->description = null;
         else {
            $this->description = json_decode($data['type_descr'], true);
         }
      }
   };
}
