<?php

$file = $_POST['file'];
$json = $_POST['json'];

file_put_contents($file, $json);

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Изменения успешны</title>
</head>
<body>
   Изменения успешно сохранены. <br>
   <a href="./">На главную</a>
   
</body>
</html>