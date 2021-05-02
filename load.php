<?php
require './load-params.php';
require './api.php';

// LOAD LOGIC SWITCH

if ($curr_date > $last_update + 1) {
   // storage is old
   
   $html = kim_download();

   if ($html) {
      $res = kim_parse($html, $weekday_number);
      kim_storage_save($res);
   } else {
      $res = kim_storage_load();
   }
} 
else {
   // storage is ok
   $res = kim_storage_load();
}

echo $res;

echo '<script>console.log(`'.$storage_file.'`);</script>';
