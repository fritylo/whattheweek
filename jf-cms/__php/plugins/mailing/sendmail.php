<?php

// load single mailing plugin

use JustField\Mailing;

require_once __DIR__ . '/../api-reg/__load.php';
require_once __DIR__ . '/../interface-addons-api/__load.php';
require_once __DIR__ . '/../mailing/__load.php';

$from = $_POST['from'];
$to = $_POST['to'];
$subject = $_POST['subject'];
$message = $_POST['message'];
$domain = $_POST['domain'];

if ($domain == 'localhost') {
   echo <<<JSON
      {
         "status": "Error",
         "message": "Sendmail do not work at localhost. You have to have some domain to send mails."
      }
JSON;
   die;
}

$mailing = new Mailing($domain);

$to_arr = explode(',', $to);
foreach ($to_arr as $recipient) {
   if (!$mailing->mail($from, $recipient, $subject, $message)) {
      echo <<<JSON
         {
            "status": "Error",
            "message": "Sendmail haven't been installed correctly. Check __php/plugins/mailing/_readme.md for more info.",
            "data": {
               "from": "$from",
               "to": "$recipient",
               "subject": "$subject",
               "message": "$message"
            }
         }
JSON;
   }
}

echo <<<JSON
   {
      "status": "OK"
   }
JSON;