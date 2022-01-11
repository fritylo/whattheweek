<?php

$path_to_jf = '/../jf-cms/__php/';

require_once __DIR__ . $path_to_jf . 'jf.php';
$reg->path_to_jf_php_folder = '.'.$path_to_jf;

require_once __DIR__ . '/../ver.php';

function get_root() {
   global $db;
   return $db->at_path('wtw');
}

function append($parent, $type_name, $key, $name) {
   global $db;

   $item_id = $parent->add_field($db->type_id($type_name));
   $field = new JustField\DBItem($db->orm, $item_id);
   $field->update('name', $name);
   $field->update('key', $key);

   return $field;
}