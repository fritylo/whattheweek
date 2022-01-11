<?php
require_once __DIR__ . '/api.php';

$root = get_root();
$excel = $root->at_path('excel');
$excel->update('value', '');
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Загружено</title>
</head>

<body>
   <h1>Файл загружен успешно</h1>
   <p>Теперь приступим к выборке данных из этого дрянного громадного файла... Поможем человечеству!! :)</p>
   <h2>Посмотрите туториал чтобы понимать что делать дальше</h2>
   <iframe width="560" height="315" src="https://www.youtube.com/embed/6Nyx8RXzfX8" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
   <form action="./select-schedule.php?id=<?= $excel->id ?>&group=<?= $_POST['group'] ?>" method="POST">
      <input type="submit" value="Продолжить" />
   </form>
</body>

</html>