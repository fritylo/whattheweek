<?php
require_once __DIR__ . '/api.php';

$group = $_POST['group'];

$schedule_json = $_POST['schedule'];
$schedule = null;
$schedule_pretty = null;

if ($schedule_json) {
   $schedule = json_decode($schedule_json);
   $schedule_pretty = json_decode($schedule_json);
}

$res = '';
$thead = '<thead>';
$tbody = '<tbody>';
$tday = '';

if ($schedule) {
   foreach ($schedule as $week_type_name => $week_type_content) {
      $res .= '<h2>'.($week_type_name == 'even' ? 'Четная' : 'Не четная').'</h2>';
      $res .= '<table>';

      $thead = '<thead><tr>';
      $is_thead = false;
      $thead_count = 0;
      $tbody = '<tbody>';

      $is_week_free = false;
      if ($week_type_name == 'odd')
         $is_week_free = true;

      foreach ($week_type_content as $week_day_name => $week_day_content) {
         $schedule_pretty->{$week_type_name}->{$week_day_name} = [];
         $tbody_loc = '';
         foreach ($week_day_content as $lesson_number => $lesson_content) {
            $tbody_loc .= '<tr>';
            $schedule_pretty->{$week_type_name}->{$week_day_name}[$lesson_number] = [];
            foreach ($lesson_content as $lesson_prop => $lesson_prop_val) {
               if ($lesson_prop == 'number') {
                  $lesson_prop_val = $lesson_number;
               }
               if (!$is_thead) {
                  $thead .= '<td>'.$lesson_prop.'</td>';
                  $thead_count++;
               }

               $schedule_pretty->{$week_type_name}->{$week_day_name}[$lesson_number][$lesson_prop] = $lesson_prop_val;

               if (strlen($lesson_prop_val) > 30) 
                  $lesson_prop_val = mb_substr($lesson_prop_val, 0, 30) . '...';
               $tbody_loc .= '<td>'.$lesson_prop_val.'</td>';

               if ($lesson_prop_val && $lesson_prop != 'number')
                  $is_week_free = false;
            }
            if (!$is_thead) {
               $is_thead = true;
               $thead .= '</tr></thead>';
            }
            $tbody_loc .= '</tr>';
         }
         $tday = '<tr><td style="text-align: center; font-weight: bold" colspan='.$thead_count.'>'.$week_day_name.'</td></tr>';
         $tbody .= $tday . $tbody_loc;
      }
      $tbody .= '</tbody>';
      $res .= $thead . $tbody . '</table>';

      if ($is_week_free) {
         $schedule_pretty->odd = $schedule_pretty->even;
      }
   }
}

$table = $res;
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Результат</title>
   <link rel="stylesheet" href="table.css?ver=<?= $VER ?>">
   <link rel="stylesheet" href="confirm.css?ver=<?= $VER ?>">
</head>
<body>
   <h1>Результаты</h1>
   <p>
      В результате твоей работы была сгенерирована следующая таблица.
      Проверь её на правильность, и затем нажми на кнопку "Сохранить расписание" в конце страниы, чтобы сохранить изменения.
   </p>
   <p>
      Если ты не заполнял нечетную неделю, то данные будут скопированы из четной, однако, в таблице ниже этого видно не будет.
   </p>
   <?= $table ?>
   <div class="row">
      <form action="save.php" method="POST">
         <input type="hidden" name="json" value="<?= htmlspecialchars(json_encode($schedule_pretty)) ?>" />
         <input type="hidden" name="group" value="<?= $group ?>" />
         <input type="submit" value="Сохранить изменения" />
      </form>
      <form action="../index.php">
         <input type="submit" value="Начать с начала" />
      </form>
   </div>
</body>
</html>
