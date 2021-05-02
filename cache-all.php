<?php 
require './api.php';
require './load-params.php';

$html = kim_download();

if ($html) {
    echo '<h1>HTML Downloaded</h1>';
    
    echo "<h2>$week_type</h2>";
    echo '<ul>';

    for ($weekday_number = 0; $weekday_number < 7; $weekday_number++) {
        // Renew params
        
        $weekday_folder = __DIR__ . "/storage/$week_type/$weekday_number";
        $storage_file = "$weekday_folder/load_{$group_name}.html";

        if (!file_exists($weekday_folder))
           mkdir($weekday_folder);

        $last_update_file = "$weekday_folder/load_{$group_name}_update_time.txt";

        // \ Renew params 

        $res = kim_parse($html, $weekday_number);
        kim_storage_save($res);
        echo "<li>Saved day: $weekday_number</li>";
    }

    echo '</ul>';
}

else {
    echo '<h1 style="color: red">Downloaded HTML is free (may be KIM died)</h1>';
    echo '<pre>$_POST:'."\n";
    print_r($_POST);
    echo '</pre>';
}
