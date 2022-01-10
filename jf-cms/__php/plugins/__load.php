<?php

function console_log($message) {
   echo "<script>console.log(`$message`);</script>";
}
function console_error($message) {
   echo "<script>console.error(`$message`);</script>";
}

class Plugin {
   function __construct($name, $folder, $manifest) {
      $this->name = $name;
      $this->folder = $folder;
      $this->manifest = $manifest;

      $this->load_path = $folder . '/__load.php';
   }
}

$plugin_list = scandir(__DIR__);
$plugins = [];

foreach ($plugin_list as $plugin) {
   if ($plugin[0] == '.') continue;

   $plugin_folder = __DIR__ . '/' . $plugin;

   if (is_dir($plugin_folder)) {
      $manifest_path = $plugin_folder . '/manifest.json';
      if (!file_exists($manifest_path)) {
         console_error("Error: no manifest in \"$plugin_folder\". Plugin \"$plugin\" won't be used.");
         continue;
      }

      $manifest = json_decode(file_get_contents($manifest_path));

      if (!$manifest->enabled) {
         console_log("Plugin \"$plugin\" won't be used because disabled");
         continue;
      }

      array_push($plugins, new Plugin($plugin, $plugin_folder, $manifest));
   }
}

usort($plugins, function ($a, $b) { return -1 * ($a->manifest->priority <=> $b->manifest->priority); });

foreach ($plugins as $plugin) {
   if (file_exists($plugin->load_path)) {
      if ( !( isset($_GET['script']) || isset($_POST['script']) ) ) // to disable logs in AJAX queries
         console_log("Plugin loaded: {$plugin->name}");
      require_once $plugin->load_path;
   }
}