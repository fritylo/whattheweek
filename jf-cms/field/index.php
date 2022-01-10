<?php
$PHP = '../'
?><?php
$VER = time();
$PHP = (isset($PHP) ? $PHP : '') . './__php';
$ATTACH = './src/__attach';
$ASSETS = './src/__assets';
$ROOT = './src/Root';
$MODE = 'dev';

require_once $PHP . '/__load.php';
?><?php
session_start();

if (!isset($_SESSION['id'])) {
   session_destroy();
   exit("<meta http-equiv='refresh' content='0; url=./../login'>");
   die;
}?><?php
$user_info = $orm->from('account')->select('*')->where("id_account = '{$_SESSION['id']}'")()[0];?><?php
if (!isset($_GET['view']))
   header('Location: ./../field?view=tree');

function query_update ($key, $value) { 
   if (!isset($_GET[$key])) 
      return; 
   return './?' . str_replace("$key=".$_GET[$key], "$key=$value", $_SERVER['QUERY_STRING']); 
};

$types = $orm->table('type')->select('*')();

use JustField\DBItem as DBItem;

?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Fields | Just Field</title>
    <link rel="apple-touch-icon" sizes="57x57" href="./../apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="./../apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="./../apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="./../apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="./../apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="./../apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="./../apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="./../apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="./../apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="./../android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./../favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="./../favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./../favicon-16x16.png">
    <link rel="manifest" href="./../manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="./../ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
  <link href="../field/field.bundle.css" rel="stylesheet"></head>
  <body class="row"><?php
$aside_width = 400;
if (array_key_exists('-jf_aside-width', $_COOKIE)) {
   $aside_width = $_COOKIE['-jf_aside-width'];
}
$anti_aside_width = "calc(100% - {$aside_width}px)";?>
    <aside class="aside rel" style="width: <?=$aside_width?>px">
      <div class="aside__content col jcsb">
        <div class="col">
          <div class="box p1 box_mode_none aside__logo row aic">
            <svg class="logo" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg" style="height: 1.75em; width: 1.75em;">
              <g clip-path="url(#clip0)">
                <path d="M33.0447 9.87597C33.3487 9.01785 34.2907 8.5686 35.1489 8.87255L48.0542 13.4437L30.4171 63.2376C30.1131 64.0957 29.1711 64.5449 28.3129 64.241L15.4076 59.6698L33.0447 9.87597Z" fill="#E6E6E6"></path>
                <path d="M16.1526 -5.10426C16.4565 -5.96238 17.3986 -6.41162 18.2567 -6.10767L30.696 -1.70163L15.9493 39.9315C15.6454 40.7897 14.7033 41.2389 13.8452 40.935L1.40596 36.5289L16.1526 -5.10426Z" fill="#E6E6E6"></path>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M25 9.67329C18.7414 9.63097 12.8629 13.5104 10.6556 19.7421C8.46611 25.9236 10.5403 32.5803 15.3466 36.5L25 9.67329ZM34.5 13.1146L25 39.9006C31.1824 39.8587 36.9579 35.9961 39.1413 29.8318C41.3233 23.6716 39.2709 17.0396 34.5 13.1146Z" fill="white"></path>
                <path d="M25.7996 4.68757L13.6919 38.8704L3.04983e-05 38.8704" stroke="black" stroke-width="5.49451" stroke-linejoin="round"></path>
                <path d="M23.392 45.2206L29.4459 28.1292M50 11.0378L35.4997 11.0378L29.4459 28.1292M29.4459 28.1292L39.0763 21.9225" stroke="black" stroke-width="5.49451" stroke-linejoin="round"></path>
              </g>
              <defs>
                <clippath id="clip0">
                  <rect width="50" height="50" fill="white"></rect>
                </clippath>
              </defs>
            </svg><strong class="plo75">Just Field CMS</strong>
          </div>
          <div class="box p1 box_mode_none aside__logged-as"><span>Logged as </span><strong class="tdu"><?= $user_info['account_login'] ?></strong>
          </div><?php
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$actual_link = trim($actual_link, "\t\n\r\0\x0B/");?><?php foreach($reg->interface->aside->menu_items as $item) : ?><?php
$is_current = false;
$is_url_match = JustField\InterfacePlugin\Aside::is_url_match($item->link, $actual_link);

if ($is_url_match)
   $is_current = true;
?>
          <a class="box p1 box_mode_ <?= ($is_current ? 'cud box_disabled box_mode_light' : 'box_mode_dark') ?> aside__item w100 db tdn" href="<?= $item->link ?>"><?= $item->title ?>
          </a><?php endforeach; ?>
        </div>
        <div class="col">
          <a class="box p1 box_mode_dark aside__item w100 db tdn" href="./../scripts?script=exit">Exit
          </a>
        </div>
      </div>
      <div class="aside__resizer abs h100"></div>
    </aside>
    <main class="rel" style="<?= "width: $anti_aside_width;" ?>">
      <div class="row page_tabs">
        <a class="box p1 box_mode_<?php echo ($_GET['view'] == 'tree' ? 'light' : 'dark') ?> tdn" href="<?= query_update('view', 'tree') ?>">Tree View
        </a>
        <a class="box p1 box_mode_<?php echo ($_GET['view'] == 'type' ? 'light' : 'dark') ?> tdn" href="<?= query_update('view', 'type') ?>">Type View
        </a>
      </div><?php if ($_GET['view'] == 'tree') : ?>
      <div class="page_path row aic w100 pl1">
        <?php
$full_path = (array_key_exists('p', $_GET) ? $_GET['p'] : '');
$curr_path_i = 0;
if (array_key_exists('pi', $_GET))
   $curr_path_i = $_GET['pi'];
$curr_path_i = intval($curr_path_i);

$parts = explode('/', $full_path);

$path_parts = [];
for ($i = 0; $i < $curr_path_i; $i++)
   array_push($path_parts, $parts[$i]);
$path = implode('/', $path_parts);

$global['path'] = $path;
$global['path_parts'] = $path_parts;
?><script>var state = {};</script>
        <script>state.path = '<?= $path ?>';</script><?php
//var_dump($parts);
echo '<script>console.log(`' . 'curr_path_i: ' . $curr_path_i .'`);</script>';
echo '<script>console.log(`' . 'count parts: ' . count($parts) .'`);</script>';
if ($curr_path_i < count($parts)-1)
   echo "<script>state.pathNext = '{$parts[$curr_path_i]}';</script>";
else
   echo "<script>state.pathNext = '';</script>";

if (count($parts) == 1 && $parts[0] == '')
   $parts = [];
array_unshift($parts, '/');
$i = 0;
?><?php foreach ($parts as $part): ?>
<?php $is_curr = ($i == $curr_path_i); ?><a class="<?= $is_curr ? 'page_path__part_curr' : '' ?> page_path__part tdn" href="<?= query_update('pi', $i) ?>"><?= $part ?></a><?php $i++; ?>
<?php endforeach; ?>
      </div>
      <div class="page_content ova w100"><script> var templates = {}; </script>
<?php foreach ($types as $curr_type) : ?>
<?php $type_name = $curr_type['type_name']; ?>
<?php if (array_key_exists($type_name, $reg->DB->type)) : ?>
<template id="template_T_<?= $type_name ?>">
<?php DBItem::render($type_name); ?>
</template>
<script>templates['<?= $type_name ?>'] = document.getElementById('template_T_<?= $type_name ?>');</script>
<?php $reg->DB->type[$type_name]::render_addictive_templates(); ?>
<?php else : ?>
<script>console.warn(`field/index.php: On template rendering, "<?= $type_name ?>" class is not registered in $reg->DB->type.`)</script>
<?php endif; ?>
<?php endforeach; ?>
<?php $is_data = true; ?>
<?php $parent = $db->at_path($path); ?>
        <table class="table" data-update-link="./../scripts/?script=field-update" data-render-link="./../scripts/?script=field-render" data-value-render-link="./../scripts/?script=field-value-render" data-parent-id="<?= $parent->id ?>">
          <thead>
            <tr>
              <td>Order</td>
              <td class="tac">ID</td>
              <td>Key</td>
              <td>Name</td>
              <td class="w100">Value</td>
              <td colspan="2">Type</td>
              <td>Permission</td>
            </tr>
          </thead>
          <tbody><?php $children = $parent->get_children(); ?>
<?php if ($children == null) : ?>
<?php $is_data = false; ?>
<?php else : ?>
<?php foreach ($children as $child) : ?>
<?php DBItem::render($child->type->name, $child); ?>
<?php endforeach; ?>
<?php endif; ?>
          </tbody>
        </table>
        <h2 class="tac <?= ( $is_data ? 'dn' : '' ) ?>" id="title_no-data">No data</h2>
      </div><?php elseif ($_GET['view'] == 'type') : ?>type<?php endif; ?>
      <div class="page_foot-panel w100 row jcsb">
        <div class="row">
          <button class="box p1 box_mode_dark button tal cup brad0 page_button_with-content page_button-add rel" data-add-link="./../scripts/?script=field-add">Add
            <div class="page_button__content abs col top0 left0 dn"><?php foreach ($types as $curr_type) : ?>
<?php $type = $curr_type['type_name']; ?>
              <div class="box p1 box_mode_dark page_button-add__type" data-id="<?= $curr_type['id_type'] ?>"> 
                <div class="page_button-add__type-icon"><?php if ($curr_type['type_icon']) : ?><img src="../__php/plugins/field-type_<?= $type ?>/<?= $curr_type['type_icon'] ?>"><?php endif; ?></div><span><?= strtoupper(substr($type, 0, 1)) . substr($type, 1) ?></span>
              </div><?php endforeach; ?>
            </div>
          </button>
          <button class="box p1 box_mode_dark button tal cup brad0 page_button-delete" data-delete-link="./../scripts/?script=field-delete">Delete<span class="dn" style="color: #6CF6FF88" id="button-delete-count"> (0)</span>
          </button>
          <button class="box p1 box_mode_dark button tal cup brad0 page_button-duplicate" data-duplicate-link="./../scripts/?script=field-duplicate">Duplicate<span class="dn" style="color: #6CF6FF88" id="button-duplicate-count"> (0)</span>
          </button><?php
$move = ''; $move_arr = [];
if (array_key_exists('-jf_move', $_COOKIE))
   $move = $_COOKIE['-jf_move'];
if ($move != '')
   $move_arr = explode(',', $move);
$move_count = count($move_arr);
?>
          <button class="box p1 box_mode_dark button tal cup brad0 page_button-move <?= ( $move ? 'dn' : '' ) ?>" data-move-link="./../scripts/?script=field-move">Move<span class="dn" style="color: #6CF6FF88" id="button-move-count"> (0)</span>
          </button>
          <button class="box p1 box_mode_light button tal cup brad0 page_button_with-content page_button-move-controls rel <?= ( $move ? '' : 'dn' ) ?>">Move<span style="color: #6e00ffa6" id="button-move-controls-count"><?= ( $move ? " ($move_count)" : ' (0)' ) ?></span>
            <div class="page_button__content abs col top0 left0 dn">
              <div class="box p1 box_mode_dark page_button-move-here" data-move-link="./../scripts/?script=field-move">Here
              </div>
              <div class="box p1 box_mode_dark page_button-move-cancel">Cancel
              </div>
            </div>
          </button>
        </div>
        <div class="row">
          <div class="p1" id="statusbar">Ready</div>
        </div>
      </div>
    </main>
  <script src="../field/field.bundle.js"></script></body>
</html>