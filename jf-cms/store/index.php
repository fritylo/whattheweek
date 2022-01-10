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
$user_info = $orm->from('account')->select('*')->where("id_account = '{$_SESSION['id']}'")()[0];?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Store | Just Field</title>
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
  <link href="../store/store.bundle.css" rel="stylesheet"></head>
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
    <main></main>
  <script src="../store/store.bundle.js"></script></body>
</html>