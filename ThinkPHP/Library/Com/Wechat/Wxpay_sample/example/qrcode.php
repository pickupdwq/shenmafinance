<?php
error_reporting(E_ERROR);
requireWxpay_sample 'phpqrcode/phpqrcode.php';
$url = urldecode($_GET["data"]);
QRcode::png($url);
