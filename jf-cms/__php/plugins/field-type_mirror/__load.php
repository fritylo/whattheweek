<?php

namespace JustField {

   class T_mirror {
      var \ORM $orm;
      var $id;

      function __construct($orm) {
         $this->orm = clone $orm;
         $this->id = null;
      }

      function _has_target($args, $callback_is_target, $callback_no_target) {
         $target_id = $this->orm->select('`db-item_value`')->where("`id_db-item` = '{$this->id}'")()[0]['db-item_value'];

         $target_field = null;
         if ($target_id) {
            $is_target_found = count($this->orm->select('`id_db-item`')->where("`id_db-item` = '{$target_id}'")());
            if ($is_target_found) {
               $target_field = new DBItem($this->orm, $target_id);
               return $callback_is_target($args, $this, $target_field);
            }
            else
               return $callback_no_target($args, $this);
         }
         else
            return $callback_no_target($args, $this);
      }

      function set_id($id) {
         $this->id = $id;
      }

      function create() {
         // all mirror create logic is in DBItem.php
         return '';
      }

      function update(DBItem $item, $value) {
         return $this->_has_target(['item' => $item, 'value' => $value],
            function ($args, T_mirror $self, DBItem $target) {
               return $target->update('value', $args['value']['value']);
            },
            function ($args, T_mirror $self) {
               // updating self value
               $target_id = $args['value']['value'];
               $self->orm->update(['db-item_value' => $target_id])->where("`id_db-item` = '{$self->id}'")();

               // taking DBItem for render_value
               $item = $args['item'];
               $item->refresh();

               ob_start();
               // now render_value works like mirror target method
               $self->render_value($item);
               $res = ob_get_clean();

               return $res;
            }
         );
      }

      function get_value() {
         return $this->_has_target([],
            function ($args, T_mirror $self, DBItem $target) {
               return $target->value;
            },
            function ($args, T_mirror $self) {
               return $this->orm->select('`db-item_value`')->where("`id_db-item` = '{$this->id}'")()[0]['db-item_value'];
            }
         );
      }

      function get_children(DBItem $item) {
         return $this->_has_target([],
            function ($args, T_mirror $self, DBItem $target) {
               return $target->get_children($target);
            },
            function ($args, T_mirror $self) {
               return null;
            }
         );
      }

      function get_child(DBItem $item, string $key) {
         return $this->_has_target([$key],
            function ($args, T_mirror $self, DBItem $target) {
               return $target->get_child($target, $args[0]);
            },
            function ($args, T_mirror $self) {
               return null;
            }
         );
      }

      function remove(DBItem $item) {
         // all logic of self remove made by DBItem.php
      }

      function duplicate_value_to(DBItem $item, DBItem $new_item) {
         // all logic of duplicate made by DBItem.php
      }

      function to_string($item_value) {
         return $this->_has_target([$item_value],
            function ($args, T_mirror $self, DBItem $target) {
               return $target->__toString();
            },
            function ($args, T_mirror $self) {
               return '';
            }
         );
      }

      static function render_props(DBItem $child = null) {
         if ($child) {
            return $child->get_type_behaviour()->_has_target([],
               function ($args, T_mirror $self, DBItem $target) {
                  $defaults =  [
                     'tr_class_addon' => "item_T_{$target->type->name}",
                     'tr_attr_addon' => "data-mirror-type=\"{$target->type->name}\"",
                     'value_td_attr' => "data-item-id=\"{$target->id}\" data-item-type=\"{$target->type->name}\""
                  ];
                  $target_behaviour = $target->get_type_behaviour($target->type->name);

                  $props = [];
                  if (method_exists($target_behaviour, 'render_props'))
                     $props = $target_behaviour::render_props($target);
                  
                  foreach ($defaults as $key => $value)
                     $props[$key] = $value;
                  
                  return $props;
               },
               function ($args, T_mirror $self) {
                  return [];
               }
            );
         }
         else {
            return [];
         }
      }

      static function render_value(DBItem $child) {
         $child->get_type_behaviour()->_has_target([],
            function ($args, T_mirror $self, DBItem $target) {
               global $reg;

               ob_start();
               $reg->DB->type[$target->type->name]::render_value($target);
               $ech = ob_get_clean();

               str_replace(">{$target->type->name}</td>", '>mirror</td>', $ech);

               echo $ech;
            },
            function ($args, T_mirror $self) {
               // rendering mirror element ?>
               <button class="box p1 box_mode_dark button tal cup brad0 w100 item_T_mirror__button_select">
                  Select
               </button>
            <?php }
         ); ?>
      <?php }

      static function render_value_template() { ?>
         <button class="box p1 box_mode_dark button tal cup brad0 w100 item_T_mirror__button_select">
            Select
         </button>
      <?php }

      static function render_addictive_templates() {
      }
   }

   $reg->DB->type['mirror'] = 'JustField\T_mirror';
}
