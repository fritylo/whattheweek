<?php
function kim_download() {
   global $schedule_url, $storage_file;

   // echo "<br>\nload_file: ".$storage_file;
   // echo "<br>\nurl: <a href=\"$schedule_url\">$schedule_url</a>";
   $kim_content = take_link($schedule_url);

   if ($kim_content['status'] == 200) {
      // echo "available";
      $html = $kim_content['html'];
   } else {
      // Ошибка. Сервер КИМ опять упал... [404]
      // echo "<br>\nget error";
      return false;
   }

   return $html;
}

function kim_parse($html, $weekday_number) {
   $res = '';

   $dom = new DOMDocument();
   @$dom->loadHTML($html);

   define('WEEKDAYS', 7);
   $week_start = $weekday_number * WEEKDAYS;
   $query_start = $week_start;
   $query_end = $week_start + WEEKDAYS;

   $last_update_class = 'timetable-last_update';
   $query_last_update = "//p[@class='$last_update_class']";
   $xpath_last_update = new DOMXpath($dom);
   $last_update_node = @$xpath_last_update->query($query_last_update)[0];
   $last_update = $last_update_node->textContent;


   $query = "//table[contains(@class,'timetable-wrapper-of-table')]/tbody/tr[$query_start<=position() and position()<$query_end]";
   $xpath = new DOMXPath($dom);
   $weekday_trs = $xpath->query($query); // weekday_trs

   $weekday_html = '';
   // print_r($weekday_trs);
   foreach($weekday_trs as $node) {
      $tr_dom = new DOMDocument(); // creating node for res
      $tr_dom->appendChild($tr_dom->importNode($node, true)); // adding node to res
      $tr = new DOMXPath($tr_dom); // XPath for filtering tds
      $tds = @$tr->query("//td[not(@rowspan='6') and not(@colspan='8')]");// taking tds without titles
      if (count($tds)) {
         $weekday_html .= '<tr>'; // wrap tds into tr
         foreach ($tds as $td) {
            $weekday_html .= html_entity_decode($td->ownerDocument->saveHtml($td));
         }
         $weekday_html .= '</tr>'; // closing tr
      }
   }

   $res .= '<table>'; // returning table
   $res .= '   <tbody>';
   $res .= $weekday_html;
   $res .= '   </tbody>';
   $res .= '</table>';
   $res .= "<div class=\"last_update\">$last_update</div>";

   return $res;
}

function kim_storage_save($res) {
   global $storage_file, $last_update_file, $curr_date;

   file_put_contents($storage_file, $res);
   file_put_contents($last_update_file, $curr_date);
}

function kim_storage_load() {
   global $storage_file;
   $res = file_get_contents($storage_file);
   return $res;
}



function take_link($link)
// taking link by curl
{
   $c = curl_init($link);
   // special options to take kim site (no security and so on)
   curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
   curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
   curl_setopt($c, CURLOPT_SSL_VERIFYHOST, false);
   //curl_setopt(... other options you want...)

   $html = curl_exec($c);

   if (curl_error($c))
      die(curl_error($c));

   // Get the status code
   $status = curl_getinfo($c, CURLINFO_HTTP_CODE);

   curl_close($c);

   return [
      'html' => $html,
      'status' => $status
   ];
}

function rrmdir($src) {
    if (file_exists($src)) {
        $dir = opendir($src);
        while (false !== ($file = readdir($dir))) {
            if (($file != '.') && ($file != '..')) {
                $full = $src . '/' . $file;
                if (is_dir($full)) {
                    rrmdir($full);
                } else {
                    unlink($full);
                }
            }
        }
        closedir($dir);
        rmdir($src);
    }
}
