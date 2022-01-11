<?php

require_once __DIR__ . '/ver.php';

$file_name = $_GET['file'];
$target_file = __DIR__ . '/storage/' . $file_name;

if (!file_exists($target_file)) {
   file_put_contents($target_file, '{}');
   chmod($target_file, 0777);
}

$repl_file = file_get_contents($target_file);
$repls = json_decode($repl_file);

$inputs = '';
foreach ($repls as $from => $to) {
   $inputs .= '<div class="row rowf1">';
   $inputs .= '<input placeholder="Искать..." role="from" value="' . $from . '" />';
   $inputs .= '<input placeholder="Заменять..." role="to" value="' . $to . '" />';
   $inputs .= '<button>x</button>';
   $inputs .= '</div>';
}

$inputs .= '<div class="row rowf1">';
$inputs .= '<input placeholder="Искать..." role="from" value="" />';
$inputs .= '<input placeholder="Заменять..." role="to" value="" />';
$inputs .= '<button>x</button>';
$inputs .= '</div>';

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Настройка замен для <?= $file_name ?></title>
   <link rel="stylesheet" href="replacements-editor.css?ver=<?= $VER ?>">
</head>

<body>
   <h1>
      <center>Настройка замен для <?= $file_name ?></center>
   </h1>
   <h2>Туториал по работе</h2>
   <iframe width="560" height="315" src="https://www.youtube.com/embed/XCIGNePaLfo" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
   <h2>Замены</h2>
   <?= $inputs ?>
   <div class="row">
      <button class="button_add-rule">Добавить правило</button>
      <form action="replacements-save.php" method="post">
         <input type="hidden" name="file" value="<?= htmlspecialchars($target_file) ?>" />
         <input type="hidden" name="json" value="<?= htmlspecialchars($repl_file) ?>" />
         <input type="submit" class="button_save" value="Сохранить замены" />
      </form>
   </div>

   <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
   <script src="replacements-editor.js?ver=<?= $VER ?>"></script>
</body>

</html>