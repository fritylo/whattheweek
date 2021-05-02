<?php
require 'ver.php';
define('COURSE_1_YEAR', 20);
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Какая блятб неделя?</title>


   <!-- Yandex.Metrika counter -->
   <script type="text/javascript">
      (function(m, e, t, r, i, k, a) {
         m[i] = m[i] || function() {
            (m[i].a = m[i].a || []).push(arguments)
         };
         m[i].l = 1 * new Date();
         k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(k, a)
      })
      (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

      ym(68187961, "init", {
         clickmap: true,
         trackLinks: true,
         accurateTrackBounce: true,
         trackHash: true
      });
   </script>
   <noscript>
      <div><img src="https://mc.yandex.ru/watch/68187961" style="position:absolute; left:-9999px;" alt="" /></div>
   </noscript>
   <!-- /Yandex.Metrika counter -->

   <link rel="stylesheet" href="style.css?ver=<?= $VER ?>">
</head>

<body>
   <main class="green" style="display: block;">
      <section>
         <h1 style="margin-top: 0;">Какая блятб неделя?</h1>
         <small>Это сайт с расписанием, который <br>НЕ ПАДАЕТ, и вроде как удобный ;)</small><br><br>
         <em>Выберите направление</em>
      </section>
      <?php
         $directions = [ 'ПИ', 'ИВТ', 'Рф', 'Ф', 'ТФ', 'ЭЭ' ];
         foreach ($directions as $direction) {
            $bakalavr = [];
            $magistr = [];

            for ($i = 0; $i < 4; $i++) {
                $year = COURSE_1_YEAR - $i;
                array_push($bakalavr, "$direction-б-о-$year");
                array_push($magistr, "$direction-м-о-$year");
            }

            $bakalavr_str = implode('', array_map(function ($el) { return "<div class=direction><a href=\"./?direction=$el\">$el</a></div>"; }, $bakalavr));
            $magistr_str = implode('', array_map(function ($el) { return "<div class=direction><a href=\"./?direction=$el\">$el</a></div>"; }, $magistr));

            echo <<<HTML
                <h3>$direction</h3>
                <div class="toggle">
                    <div class="toggle__title">Бакалавриат</div>
                    <div class="toggle__content">
                        $bakalavr_str
                    </div>
                </div>
                <div class="toggle">
                    <div class="toggle__title">Магистратура</div>
                    <div class="toggle__content">
                        $magistr_str
                    </div>
                </div>
HTML;
         }
      ?>
   </main>
   <center class="footer" style="">

      <!-- Yandex.Metrika informer -->
      <a style="height: 2em" href="https://metrika.yandex.ru/stat/?id=68187961&amp;from=informer"
      target="_blank" rel="nofollow"><img src="https://informer.yandex.ru/informer/68187961/3_0_ECECECFF_CCCCCCFF_0_pageviews"
      style="width:88px; height:31px; border:0;" alt="Яндекс.Метрика" title="Яндекс.Метрика: данные за сегодня (просмотры, визиты и уникальные посетители)" /></a>
      <!-- /Yandex.Metrika informer -->
   </center>

   <script src="https://unpkg.com/@popperjs/core@2"></script>
   <script src="https://unpkg.com/tippy.js@6"></script>

   <script src="./adblock-sniper.js?ver=<? $VER ?>"></script>
   <script src="select.js?ver=<?= $VER ?>"></script>
</body>

</html>
