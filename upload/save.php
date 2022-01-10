<?php
require_once __DIR__ . '/api.php';

$group = $_POST['group'];

$json = json_decode($_POST['json']);
$json->time = strtotime('now');
$json_str = json_encode($json);

$filename = __DIR__ . '/../storage/' . $group . '.json';

file_put_contents($filename, $json_str);
chmod($filename, 0777);
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>
</head>
<body>
   <p>Изменения успешно сохранены.</p>
   <form action="../index.php">
      <input type="submit" value="На главную" />
   </form>
</body>
</html>