<?php
require_once __DIR__ . '/api.php';
require_once __DIR__ . '/../ver.php';

$root = get_root();
$excel = $db->at_id($_GET['id']);
$group = $_GET['group'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Выборка расписания</title>
   <link rel="stylesheet" href="table.css?ver=<?= $VER ?>">
   <link rel="stylesheet" href="select.css?ver=<?= $VER ?>">
</head>

<body>
   <?= $excel->api->get_html(); ?>

   <div class="select-order">
      <div class="select-order__weeks row">
         <div class="select-order__week selected" data-value="even">Четная неделя</div>
         <div class="select-order__week" data-value="odd">Не четная неделя</div>
      </div>
      <div class="select-order__days row">
         <div class="select-order__day selected" data-value="Пн">Пн</div>
         <div class="select-order__day" data-value="Вт">Вт</div>
         <div class="select-order__day" data-value="Ср">Ср</div>
         <div class="select-order__day" data-value="Чт">Чт</div>
         <div class="select-order__day" data-value="Пт">Пт</div>
      </div>
      <div class="select-order__props row">
         <div class="select-order__prop selected" data-value="number" data-start="Номер пары"></div>
         <div class="select-order__prop" data-value="type" data-start="Тип пары (ЛК, ПЗ)"></div>
         <div class="select-order__prop" data-value="name" data-start="Название"></div>
         <div class="select-order__prop" data-value="teacher" data-start="Преподаватель"></div>
         <div class="select-order__prop" data-value="vk" data-start="Чат ВК"></div>
         <div class="select-order__prop" data-value="classroom" data-start="Ссылка или аудитория"></div>
      </div>
      <div class="select-order__controls">
         <div class="select-order__control-button" role="moveup">&mapstoup;</div>
         <div class="select-order__control-button" role="movedown">&mapstodown;</div>
         <div class="select-order__control-button" role="finish" title="Нажмите чтобы закончить выборку расписания">
            Завершить
            <form class="dn" action="./confirm.php" method="post">
               <input type="text" name="schedule" role="finish-storage" />
               <input type="text" name="group" value="<?= $group ?>" />
            </form>
         </div>
      </div>
   </div>
   <div class="select-order__hint"></div>

   <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
   <script src="select.js?ver=<?= $VER ?>"></script>
</body>

</html>