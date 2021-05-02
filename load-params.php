<?php

$schedule_url = html_entity_decode($_POST['schedule_link']);
// echo '<script>console.log(`' . "$schedule_url <<< {$_POST['schedule_link']}" . '`);</script>';
$group_name = html_entity_decode($_POST['group']);
$week_type = html_entity_decode($_POST['week_type']);
$weekday_number = $_POST['weekday_number'];
$weekday_folder = __DIR__ . "/storage/$week_type/$weekday_number";
$storage_file = "$weekday_folder/load_{$group_name}.html";

if (!file_exists($weekday_folder))
   mkdir($weekday_folder);

$last_update_file = "$weekday_folder/load_{$group_name}_update_time.txt";
if (file_exists($last_update_file)) {
   $last_update = intval(file_get_contents($last_update_file));
} else {
   $last_update = 0;
}

$curr_date = date("Ymd", time());
