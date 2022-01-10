<?php

namespace JustField {
   class Mailing {
      var string $sender_domain;

      var string $message_header;
      var string $message_footer;

      public function __construct($sender_domain, $message_header = '', $message_footer = '') {
         $this->sender_domain = $sender_domain;
         
         $this->message_header = $message_header;
         $this->message_footer = $message_footer;
      }

      /**
       * PHP mail() function wrapper. Defines correct headers format, to messages don't fall to spam.
       * @param string $from Sender of email, within your domain, e.g. `admin` or `no-reply`.
       * @param string $to Email receiver. Could be free if you use visible_recipients or hidden_recipients params.
       * @param string $subject Subject of email - simple string, not HTML.
       * @param string $html_message Message of mail in HTML syntax.
       * @param array<string> $additional_visible_mail_recipients_strings_array Email addresses, which will receive message. If $from param is used with this param, then $from param is adding to begin of recipients and then send message. If $from param is free, then this param become main, and recipients are defined here.
       * @param array<string> $additional_hidden_mail_recipients_strings_array Email addresses, which will also receive message, but this recipients will be not in recipients list in mail, they will be hidden.
       * @param array<string> $additional_headers_strings_array Array of additional headers. All lines must be trimmed.
       * @param string Additional parameters string for php mail function.
       * @return boolean Email sent successfully or not.
       */
      function mail(
         string $from, 
         string $to, 
         string $subject, 
         string $html_message, 
         array $additional_visible_mail_recipients_strings_array = [],
         array $additional_hidden_mail_recipients_strings_array = [],
         array $additional_headers_strings_array = [], 
         string $additional_parameters = ''
      ) {
         // "from" header
         $final_headers = "From:$from@{$this->sender_domain} \r\n";

         // "Cc" and "Bcc" headers, if such args given
         if (count($additional_visible_mail_recipients_strings_array) > 0)
            $final_headers .= "Cc:" . implode(',', $additional_visible_mail_recipients_strings_array) . " \r\n"; // another recipients visible
         if (count($additional_hidden_mail_recipients_strings_array) > 0)
            $final_headers .= "Bcc:" . implode(',', $additional_hidden_mail_recipients_strings_array) . " \r\n"; // another recipients hidden
            
         // Some default headers
         $final_headers .= "MIME-Version: 1.0\r\n";
         $final_headers .= "Content-type: text/html\r\n";

         // Adding additional headers to the end of $final headers
         $final_headers .= implode(" \r\n", $additional_headers_strings_array) . " \r\n";

         // Wrapping message to message_header and message_footer
         $html_message = $this->message_header . $html_message . $this->message_footer;
         

         // sendmail usage with generated params
         $res = null; // $res will become true or false finally.

         // branching according to $additional_parameters
         if ($additional_parameters) 
            $res = mail($to, $subject, $html_message, $final_headers, $additional_parameters);
         else
            $res = mail($to, $subject, $html_message, $final_headers);
         
         return $res;
      }
   }

   class MailingConfig {
      private $_selectors_to_emails = [];

      function set_selectors_to_emails($func) {
         $this->_selectors_to_emails[0] = $func;
      }

      function selectors_to_emails(DBItem $selectors) {
         return $this->_selectors_to_emails[0]($selectors);
      }
   }
   $reg->mailing = new MailingConfig();

   require_once __DIR__ . '/page.php';

   $reg->interface->aside->add_menu_item('Mailing', '../plugin-page/?p=mailing');
   $reg->interface->plugin_page->add_renderer(
      'mailing', 
      'Mailing', 
      'mailing_page', // rendering function
      null, // foot panel
      '<style>' . file_get_contents(__DIR__ . '/page.css') . '</style>', 
      '<script>' . file_get_contents(__DIR__ . '/page.js') . '</script>'
   );
}