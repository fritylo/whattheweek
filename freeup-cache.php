<?php 
require './api.php';
require './load-params.php';

$html = kim_download();

if ($html) {
    // echo '<h1>HTML Downloaded</h1>';
    
    rrmdir('./storage/green');
    rrmdir('./storage/red');
    mkdir('./storage/green');
    mkdir('./storage/red');
    echo '{"message":"OK"}';
}

else {
    echo "{\"message\": \"BAD\", \"post\": ". json_encode(print_r($_POST, true)). "}";
}
