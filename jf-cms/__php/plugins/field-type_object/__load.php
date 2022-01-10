<?php

namespace JustField {

   class T_object {
      var \ORM $orm;
      var $id;

      function __construct($orm) {
         $this->orm = clone $orm;
         $this->id = null;
      }

      function set_id($id) {
         $this->id = $id;
      }

      function create() {
         // all object create logic is in DBItem.php
         return '';
      }

      function update(DBItem $item, $value) {
         $this->orm->update(['db-item_value' => $value['value']])->where("`id_db-item` = '{$this->id}'")();
      }

      function get_value($data = null) {
         if (!$data)
            return $this->orm->select('`db-item_value`')->where("`id_db-item` = '{$this->id}'")()[0]['db-item_value'];
         else {
            return $data;
         }
      }

      function get_children(DBItem $item) {
         $value = $item->value;
         if (!$value) return null;

         $res = $this->orm
            ->from('db-item')
            ->select('`id_db-item`')
            ->where("`db-item_parent` = '{$this->id}'")
            ();

         if ($res) {
            $children = [];

            $children_mixed = [];
            foreach ($res as $row)
               $children_mixed[$row['id_db-item']] = new DBItem($this->orm, $row['id_db-item']);

            foreach (explode(',', $value) as $id)
               array_push($children, $children_mixed[$id]);
            
            return $children;
         }
         else
            return null;
      }

      function get_child(DBItem $item, string $key) {
         $value = $item->value;
         if (!$value) return null;

         $res = $this->orm
            ->from('db-item')
            ->select('`id_db-item`')
            ->where("`db-item_key` = '$key' AND `db-item_parent` = '{$this->id}'")
            ();

         if ($res)
            return new DBItem($item->orm, $res[0]['id_db-item']);
         else
            return null;
      }

      function remove(DBItem $item) {
         // all logic of self remove made by DBItem.php

         // logic of child delete
         $children = $this->get_children($item);
         if ($children) {
            foreach ($children as $child) {
               $child->remove();
            }
         }
      }

      function duplicate_value_to(DBItem $item, DBItem $new_item) {
         // take all OLD children
         $children = $item->get_children($item);

         // if no children in old item, then we can exit
         if (!$children) return; // if no children given, then $children === null
         // if there are some children in old item, then we are here

         $new_children_id = []; // creating array to store children duplicates IDs
         // then iterating each children and making duplicates from old item to new one
         foreach ($children as $child) {
            // receiving duplicate ID to variable
            $new_child_id = DBItem::duplicate_field_to($child, $new_item)->new_field_id; // duplicate child 
            array_push($new_children_id, $new_child_id); // adding duplicate ID to storage
         }
         // if we are here, then $new_children_id is full, and has at list one duplicate ID

         // now lets update the parent of children duplicates, to bind children to parent
         $new_item->update('value', implode(',', $new_children_id)); // insert new children ids as value of new object
      }

      function to_string($item_value) {
         return $item_value;
      }

      static function render_value(DBItem $child) { ?>
         <?php
         $path = substr($child->path, 1);
         $path_parts = explode('/', $path);
         $path_i = count($path_parts);
         ?>
            <a class="link p1 db" href="./../field?view=tree&p=<?= $path ?>&pi=<?= $path_i ?>">Open</a>
      <?php }

      static function render_value_template() { ?>
         <a class="link p1 db" href="./../field?view=tree&p={path}{key}&pi={path_i}">Open</a>
      <?php }

      static function render_addictive_templates() {
      }
   }

   $reg->DB->type['object'] = 'JustField\T_object';
}
