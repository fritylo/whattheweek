<?php
function get_file_any_ext($assets_folder, $filename, $ext_pattern) {

   $directory = $assets_folder;

   $filenames = scandir($directory);
   $pattern = "/^" . $filename . "\.(". $ext_pattern .")$/";

   foreach ($filenames as $filename) {
      preg_match($pattern, $filename, $matches);
      if ($matches) {
         return $filename;
      }
   }

   return false;
}
