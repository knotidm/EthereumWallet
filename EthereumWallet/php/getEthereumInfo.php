<?php
ini_set("allow_url_fopen", 1);
error_reporting(E_ALL);
$string  = file_get_contents('https://api.coinmarketcap.com/v1/ticker/?limit=2');
echo $string;