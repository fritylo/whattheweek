<?php

require_once __DIR__ . '/upload-exception.php';
require_once __DIR__ . '/get-file-any-ext.php';


// For DB queries and DBItem
require_once __DIR__ . '/../api-reg/__load.php';
require_once __DIR__ . '/../api-orm/__load.php';
require_once __DIR__ . '/../api-db/__load.php';
require_once __DIR__ . '/../field-type_text/__load.php';
require_once __DIR__ . '/../plugin-config/__load.php';

$db = new JustField\DB($orm);


$assets_folder = '__assets/T_text/';
$php_assets_folder = '../../../' . $assets_folder;

$item_id = $_POST['item-id'];
$id = $_POST['id'];
$file = $_FILES['image'];
$host = $_POST['host'];

if ($file['error'] != UPLOAD_ERR_OK) 
   throw new UploadException($value['error']);
   
$orm->is_log = true;
$field_id = $db->at_id($item_id)->value_id;

$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
$target_name = "$field_id/{$id}.{$ext}";
$target_file = $reg->path_to_jf_php_folder . "$php_assets_folder$target_name"; // assets_folder has '/' at end

move_uploaded_file($file['tmp_name'], $target_file);
chmod($target_file, 0777);

// TODO: host must be insered on data rendering, because of migration thoughts
$target_file_url = "../$assets_folder$target_name";

echo <<<JSON
{
   "status": "OK",
   "success" : 1,
   "file": {
      "url" : "$target_file_url"
   }
}
JSON;