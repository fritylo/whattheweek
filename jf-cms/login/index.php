<?php
$PHP = '../';

session_start();
if (isset($_SESSION['id'])) {
   exit("<meta http-equiv='refresh' content='0; url=./../dashboard'>");
   die;
}
?><?php
$VER = time();
$PHP = (isset($PHP) ? $PHP : '') . './__php';
$ATTACH = './src/__attach';
$ASSETS = './src/__assets';
$ROOT = './src/Root';
$MODE = 'dev';

require_once $PHP . '/__load.php';
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login | Just Field</title>
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
  <link href="../login/login.bundle.css" rel="stylesheet"></head>
  <body class="row jcc aic">
    <main class="rel">
      <div class="jf-cms-span row jcc">
        <div class="jf-cms-span_1">JUST&nbsp;</div>
        <div class="jf-cms-span_2">FIELD&nbsp;</div>
        <div class="jf-cms-span_3">CM</div>
        <div class="jf-cms-span-ll">S</div>
      </div>
      <section class="row aic jcsb">
        <svg class="logo mlv1" width="222" height="245" viewBox="0 0 222 245" fill="none" xmlns="http://www.w3.org/2000/svg" style="overflow: visible;">
          <g filter="url(#filter0_d)">
            <path d="M138.352 66.5782C139.386 63.6606 142.589 62.1331 145.506 63.1666L189.385 78.7084L145.36 203L90.0311 203L138.352 66.5782Z" fill="#C4C4C4"></path>
            <path d="M80.228 168.767C79.1946 171.685 75.9917 173.212 73.074 172.179L30.7805 157.198L74.772 33L128.317 33L80.228 168.767Z" fill="#C4C4C4"></path>
            <path fill-rule="evenodd" clip-rule="evenodd" d="M111 65.8891C89.7207 65.7452 69.7341 78.9351 62.2293 100.123C54.7849 121.14 61.8373 143.773 78.1786 157.1L111 65.8891ZM143.3 77.5896L111 168.662C132.02 168.52 151.657 155.387 159.081 134.428C166.499 113.483 159.521 90.9346 143.3 77.5896Z" fill="white"></path>
            <path d="M113.719 48.9377L72.5525 165.159L26.0001 165.159" stroke="black" stroke-width="18.6813" stroke-linejoin="round"></path>
            <path d="M105.533 186.75L126.116 128.639M196 70.5283L146.699 70.5285L126.116 128.639M126.116 128.639L158.859 107.536" stroke="black" stroke-width="18.6813" stroke-linejoin="round"></path>
          </g>
          <defs>
            <filter id="filter0_d" x="0.505342" y="0.891874" width="220.989" height="243.496" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
              <feflood flood-opacity="0" result="BackgroundImageFix"></feflood>
              <fecolormatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"></fecolormatrix>
              <feoffset dy="4.35897"></feoffset>
              <fegaussianblur stdDeviation="9.80769"></fegaussianblur>
              <fecolormatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"></fecolormatrix>
              <feblend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow"></feblend>
              <feblend mode="normal" in="SourceGraphic" in2="effect1_dropShadow" result="shape"></feblend>
            </filter>
          </defs>
        </svg>
        <form class="col mr1" action="./../scripts/" method="post">
          <input class="box p1 box_mode_none input rel" name="login" type="text" placeholder="Login">
          </input>
          <input class="box p1 box_mode_none input rel" name="" type="password" placeholder="Password" id="password-view">
          </input>
          <input class="box p1 box_mode_light input rel" name="password" type="hidden" placeholder="Password" id="password">
          </input>
          <input class="box p1 box_mode_light input rel" name="script" type="hidden" placeholder="Script" value="login">
          </input>
          <button class="box p1 box_mode_none button tal cup brad0">Sign in
          </button>
        </form>
      </section>
      <div class="jf-cms-span jf-cms-span_updown row jcc"> <span>JUST FIELD CM</span>
        <div class="jf-cms-span-ll">S</div>
      </div><a class="link abs fzo75 ct-abs_x" href="http://frity.ru" target="_blank">frity corp.</a><?php if (isset($_SESSION['login_error'])) : ?>
      <div class="login-error abs ct-abs_x"><?= $_SESSION['login_error'] ?></div><?php endif; ?>
    </main>
  <script src="../login/login.bundle.js"></script></body>
</html>