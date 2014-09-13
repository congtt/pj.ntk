<?php

ob_start("ob_gzhandler");

$offset = 84600*365;
$expire = "expires: " . gmdate ("D, d M Y H:i:s", time() + $offset) . " GMT";

header ("content-type: text/css; charset: UTF-8");
header ("cache-control: must-revalidate");
header ($expire);


$path = realpath(".") . "/";
echo file_get_contents($path. $_GET['file']);
ob_end_flush();