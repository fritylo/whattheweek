<?php

require_once __DIR__ . '/upload-exception.php';
require_once __DIR__ . '/get-file-any-ext.php';


$assets_folder = '__assets/T_text/';
$php_assets_folder = '../../../' . $assets_folder;

$file_name = $_POST['file-name'];
$target_file = $php_assets_folder . $file_name;

if (file_exists($target_file))
   unlink($target_file);

echo <<<JSON
{
   "status": "OK"
}
JSON;