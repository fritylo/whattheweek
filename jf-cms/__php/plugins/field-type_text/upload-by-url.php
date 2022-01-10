<?php

echo <<<JSON
{
   "status": "OK",
   "success" : 1,
   "file": {
      "url" : "{$_POST['image']}"
   }
}
JSON;