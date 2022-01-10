<?php
$plugin_store_host = 'http://localhost/just-field-store';
$plugin_name = 'field-type_field';

$plugin_folder = file_get_contents($plugin_store_host . '/storage/' . $plugin_name);
echo $plugin_folder;
