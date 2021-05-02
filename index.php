<?php
require 'ver.php';
?>

<?php
if (!array_key_exists('direction', $_GET)) {
    header('Location: ./select.php');
}

function console_log($message) {
    echo '<script>console.log(`' . $message . '`)</script>';
}


$direction = $_GET['direction'];

$GLOBALS['link_mask'] = [
    "{$direction}1(1)",
    "{$direction}1(2)",
    "{$direction}2(1)",
    "{$direction}2(2)",
    "{$direction}3(1)",
    "{$direction}3(2)",
];

if (mb_substr($direction, 0, 2) == 'ЭЭ') {
    $year = mb_substr($direction, 7, 2);
    console_log($year);
    switch ($year) {
        case '20':
            console_log('is 20');
            $GLOBALS['link_mask'] = [
                'ЭЭ-б-о 201(1)',
                'ЭЭ-б-о-201(2)',
                'ЭЭ-б-о-202(1)',
                'ЭЭ-б-о-202(2)',
                'ЭЭ-б-о-203(1)',
                'ЭЭ-б-о-203(2)',
            ];
            break;
        case '19':
            $GLOBALS['link_mask'] = [
                'ЭЭ-б-о -191(1)',
                'ЭЭ-б-о-191(2)',
                'ЭЭ-б-о-192(1)',
                'ЭЭ-б-о-192(2)',
                'ЭЭ-б-о-193(1)',
                'ЭЭ-б-о-193(2)',
            ];
            break;
        case '18':
            $GLOBALS['link_mask'] = [
                'ЭЭ-б-о -181(1)',
                'ЭЭ-б-о-181(2)',
                'ЭЭ-б-о-182(1)',
                'ЭЭ-б-о-182(2)',
                'ЭЭ-б-о-183(1)',
                'ЭЭ-б-о-183(2)',
            ];
            break;
        case '17':
            $GLOBALS['link_mask'] = [
                'ЭЭ-б-о -171(1)',
                'ЭЭ-б-о-171(2)',
                'ЭЭ-б-о-172(1)',
                'ЭЭ-б-о-172(2)',
                'ЭЭ-б-о-173(1)',
                'ЭЭ-б-о-173(2)',
            ];
            break;
    };
}

$GLOBALS['direction'] = $direction;
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

   <!-- PC block -->
   <!-- Yandex.RTB R-A-665787-2 -->
<!--
   <div id="yandex_rtb_R-A-665787-2"></div>
   <script type="text/javascript">
      (function(w, d, n, s, t) {
         w[n] = w[n] || [];
         w[n].push(function() {
            Ya.Context.AdvManager.render({
               blockId: "R-A-665787-2",
               renderTo: "yandex_rtb_R-A-665787-2",
               async: true
            });
         });
         t = d.getElementsByTagName("script")[0];
         s = d.createElement("script");
         s.type = "text/javascript";
         s.src = "//an.yandex.ru/system/context.js";
         s.async = true;
         t.parentNode.insertBefore(s, t);
      })(this, this.document, "yandexContextAsyncCallbacks");
   </script>
-->

   <!-- Mobile block -->
   <!-- Yandex.RTB R-A-665787-1 -->
   <div id="yandex_rtb_R-A-665787-1"></div>
   <script type="text/javascript">
      (function(w, d, n, s, t) {
         w[n] = w[n] || [];
         w[n].push(function() {
            Ya.Context.AdvManager.render({
               blockId: "R-A-665787-1",
               renderTo: "yandex_rtb_R-A-665787-1",
               async: true
            });
         });
         t = d.getElementsByTagName("script")[0];
         s = d.createElement("script");
         s.type = "text/javascript";
         s.src = "//an.yandex.ru/system/context.js";
         s.async = true;
         t.parentNode.insertBefore(s, t);
      })(this, this.document, "yandexContextAsyncCallbacks");
   </script>

   <main class="">
      <section class="info-block">
         <h1 style="margin-top: 0;">Какая блятб неделя?</h1>
         <p class="week"></p>
         <h2>Расписания</h2>
         <?php
         function make_link_generator($week_color) {
            return function ($group) use ($week_color) {
               return "https://kimcfuv.ru/po-gruppam/?Selected_Group=$group&Selected_WeekType=$week_color";
            };
         }

         function make_week_block($week_color) {
            $direction = $GLOBALS['direction'];
            $link = make_link_generator($week_color);

            if ($week_color == "Зеленая+неделя") {
               $wrapper_class = "green-list";
            } else {
               $wrapper_class = "red-list";
            }

            console_log(print_r($GLOBALS['link_mask'], true));
            $links = [
               $link($GLOBALS['link_mask'][0]),
               $link($GLOBALS['link_mask'][1]),
               $link($GLOBALS['link_mask'][2]),
               $link($GLOBALS['link_mask'][3]),
               $link($GLOBALS['link_mask'][4]),
               $link($GLOBALS['link_mask'][5]),
            ];

            return <<<HTML
               <div class="week-wrapper">
                  <div class="$wrapper_class">
                     <div class="row">
                        <a class="special" href="{$links[0]}">{$direction}1(1)</a>
                        <a class="special" href="{$links[1]}">{$direction}1(2)</a>
                     </div>
                     <div class="row">
                        <a class="special" href="{$links[2]}">{$direction}2(1)</a>
                        <a class="special" href="{$links[3]}">{$direction}2(2)</a>
                     </div>
                     <div class="row">
                        <a class="special" href="{$links[4]}">{$direction}3(1)</a>
                        <a class="special" href="{$links[5]}">{$direction}3(2)</a>
                     </div>
                  </div>
               </div>
   HTML;
         }
         ?>

         <?= make_week_block("Зеленая+неделя"); ?>
         <?= make_week_block("Красная+неделя"); ?>
      </section>
      <section class="weekdays">
         <div class="color-switch" id="colorSwitch">#</div>
         <div data-number="1">Пн</div>
         <div data-number="2">Вт</div>
         <div data-number="3">Ср</div>
         <div data-number="4">Чт</div>
         <div data-number="5">Пт</div>
         <!-- <div data-number="6">Сб</div> -->
         <!-- <div data-number="0">Вс</div> -->
      </section>
      <section class="today-schedule">
         <div class="today-schedule__message">Выберите свою группу</div>
      </section>
   </main>
   <center class="footer" style="">
      <button id="updateButton" class="slide-button">Обновить расписание групп</button>
      <a href="#" target="_blank">
         <button class="slide-button kim-open">Открыть на сайте КИМ</button>
      </a>

      <!-- Yandex.Metrika informer -->
      <a style="height: 2em" href="https://metrika.yandex.ru/stat/?id=68187961&amp;from=informer"
      target="_blank" rel="nofollow"><img src="https://informer.yandex.ru/informer/68187961/3_0_ECECECFF_CCCCCCFF_0_pageviews"
      style="width:88px; height:31px; border:0;" alt="Яндекс.Метрика" title="Яндекс.Метрика: данные за сегодня (просмотры, визиты и уникальные посетители)" /></a>
      <!-- /Yandex.Metrika informer -->
   </center>
    <footer style="color: white; font: italic 0.8em monospace; text-align: center;">
        Вопросы, предложения, баги? Пиши: <a href="https://vk.com/fritylo">VK</a>, <a href="mailto:nikonovfedor36936@gmail.com">Email</a>. Создатель сайта: Никонов Фёдор ПИ-201(2), ak fritylo.
    </footer>

   <script src="https://unpkg.com/@popperjs/core@2"></script>
   <script src="https://unpkg.com/tippy.js@6"></script>

   <script src="./adblock-sniper.js?ver=<? $VER ?>"></script>
   <script src="script.js?ver=<?= $VER ?>"></script>
</body>

</html>
