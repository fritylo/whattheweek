<?php

require_once __DIR__ . '/api.php';

if ($db->get_root()->has_path('wtw')) {
   echo 'cancel: wtw already exist.';
   die;
}

$wtw = append($db->get_root(), 'object', 'wtw', 'WhatTheWeek');
$excel = append($wtw, 'excel', 'excel', 'Excel for processing');

echo 'installation success';