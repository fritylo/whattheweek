<?php

namespace JustField {
   class DBItem
   {
      function __construct($orm, $id, $glo, $parent_path = '')
      {
         $this->orm = $orm;
         $this->id = $id;
         $this->glo = $glo;

         $data = $this->orm->from('db-item')->select('*')->where("`id_db-item` = '$id'")();
         if ($data === false || count($data) == 0) {
            var_dump($data);
            $this->orm->is_simulate = true;
            $sql = $this->orm->from('db-item')->select('*')->where("`id_db-item` = '$id'")();
            throw new \Exception("No data in $id in JustField\\DBItem::__construct ( $sql )");
         }
         $data = $data[0];

         $this->key = $data['db-item_key'];
         $this->name = $data['db-item_name'];

         $this->path = "{$parent_path}/{$this->key}";

         if ($data['db-item_value-type'] == '')
            $this->type = null;
         else
            $this->type = new DBItemType($orm, $data['db-item_value-type']);
         if ($data['db-item_value-subtype'] == '')
            $this->subtype = null;
         else
            $this->subtype = new DBItemType($orm, $data['db-item_value-subtype']);

         $this->value = $this->get_value($data, $this->type->name);
         $this->value_id = $data['db-item_value'];

         $this->parent = $data['db-item_parent'];
      }

      private function get_value($item_data, $type_name)
      {
         $value = $item_data['db-item_value'];

         if ($value == '') return null;

         switch ($type_name) {
            case 'field':
               $field = new T_field($this->orm);
               $field->set_id($value);
               return $field->get_value();
            case 'image':
               $field = new T_image($this->orm, $this->glo);
               $field->set_id($value);
               return $field->get_value();

            case 'list':
            case 'object':
               return explode(',', $value);
         };
      }


      function get_children()
      {
         if (!($this->type->name == 'list' || $this->type->name == 'object')) return null;
         if (!$this->value) return null;

         $res = [];
         foreach ($this->value as $child_id) {
            array_push($res, new DBItem($this->orm, $child_id, $this->glo));
         }
         return $res;
      }
      function get_child($key)
      {
         if (!($this->type->name == 'list' || $this->type->name == 'object')) return null;
         if (!$this->value) return null;

         $this->orm->from('db-item');

         foreach ($this->value as $child_id) {
            $curr = $this->orm->select('*')->where("`id_db-item` = '$child_id'")()[0];
            if ($curr['db-item_key'] == $key) {
               return new DBItem($this->orm, $child_id, $this->glo, $this->path);
            }
         }
         return null;
      }

      function at_path($path)
      {
         $root = $this;

         if (!$path) return $root;

         $parts = explode('/', $path);
         $target = $root;
         foreach ($parts as $part) {
            $child = $target->get_child($part);
            if (!$child)
               throw new \Exception('During ' . $path . ' processing: path part (' . $part . ') a child');
            $target = $child;
         }

         return $target;
      }

      function add_field($field_type_id)
      {
         //echo '<script>/*' . "1: Adding type id: $field_type_id" . '*/</script>';

         $type = new DBItemType($this->orm, $field_type_id);

         $field_id = null;

         // put value to T table
         if (!($type->name == 'object' || $type->name == 'list' || $type->name == 'space')) {
            if ($type->name == 'field') {
               $field = new T_field($this->orm);
            } else if ($type->name == 'image') {
               $field = new T_image($this->orm, $this->glo);
            }
            $field_id = $field->create();
         }

         // insert new field
         $this->orm->from('db-item')->insert([
            'id_db-item' => null,
            'db-item_key' => null,
            'db-item_name' => '',
            'db-item_value' => $field_id ? "$field_id" : '',
            'db-item_value-type' => "$field_type_id",
            'db-item_value-subtype' => null,
            'db-item_parent' => $this->id,
         ])();

         // taking new field id
         $new_field_id = $this->orm->select('MAX(`id_db-item`) AS max_id')()[0]['max_id'];

         // updating self value (special for duplicate)
         if ($this->value)
            array_push($this->value, $new_field_id);
         else
            $this->value = [$new_field_id];

         // update current field
         $this->orm->from('db-item')->update(['db-item_value' => implode(',', $this->value)])->where("`id_db-item` = '{$this->id}'")();

         return $new_field_id;
      }

      function update($key, $value)
      {
         switch ($key) {

            case 'value':
               switch ($this->type->name) {

                  case 'field':
                     $field = new T_field($this->orm);
                     $field->set_id($this->value_id);
                     $field->update($value);
                     break;

                  case 'image':
                     $field = new T_image($this->orm, $this->glo);
                     $field->set_id($this->value_id);
                     return $field->update($_FILES['value']);
                     break;
               }
               break;

            case 'key':
            case 'name':
               $this->orm->from('db-item')->update([
                  "db-item_$key" => "$value",
               ])->where("`id_db-item` = '{$this->id}'")();
               break;

            default:
               throw new \Exception("Error: DBItem::update(\$key=$key, \$value=$value) - unexpected key ($key)");
         };
      }

      function remove()
      {
         // value remove
         switch ($this->type->name) {
            case 'field':
               $field = new T_field($this->orm);
               $field->set_id($this->value_id);
               $field->delete();
               break;
            case 'image':
               $field = new T_image($this->orm, $this->glo);
               $field->set_id($this->value_id);
               $field->delete();
               break;
            case 'object':
            case 'list':
               $children = $this->get_children();
               if ($children) {
                  foreach ($children as $child) {
                     $child->remove();
                  }
               }
         };

         // self remove
         $parent = new DBItem($this->orm, $this->parent, $this->glo);
         $parent_value = $parent->value;
         $this_id_in_val = array_search("{$this->id}", $parent_value);
         unset($parent_value[$this_id_in_val]);

         $parent->orm->update(['db-item_value' => implode(',', $parent_value)])();
         $this->orm->delete()->where_id($this->id)();
      }

      function duplicate()
      {
         return $this->duplicate_field_to($this, new DBItem($this->orm, $this->parent, $this->glo));
      }

      private function duplicate_field_to(DBItem $field, DBItem $target_parent)
      {
         $orm = $this->orm;

         $new_field_id = $target_parent->add_field($field->type->id);
         $new_field = new DBItem($orm, $new_field_id, $field->glo);

         $field_data = [
            'key' => $field->key,
            'name' => $field->name,
         ];

         foreach ($field_data as $key => $value) {
            $new_field->update($key, $value);
         }

         if ($field->type->name == 'object' || $field->type->name == 'list') {
            $children = $field->get_children();

            foreach ($children as $child) {
               $this->duplicate_field_to($child, $new_field);
            }
         } else { // simple data
            if ($field->type->name == 'image') {
               $new_field_image = new T_image($new_field->orm, $new_field->glo);
               $new_field_image->set_id($new_field->value_id);
               $new_field_image->duplicate_file($field->value_id);
            } else {
               $new_field->update('value', $field->value);
            }
         }

         return $new_field_id;
      }
   };
}
