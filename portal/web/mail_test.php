<?php
error_reporting(E_ALL|E_STRICT);
ini_set('display_errors', 1);
$message = "Line 1\r\nLine 2\r\nLine 3";


$message = wordwrap($message, 70, "\r\n");


$sent = mail('caffeinated@example.com', 'My Subject', "test", null,'-fnoreply@example.com');

var_dump($sent);