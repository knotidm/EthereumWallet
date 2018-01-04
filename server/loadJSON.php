<?php
ini_set("allow_url_fopen", 1);
error_reporting(E_ALL);
$string  = file_get_contents('https://api.nicehash.com/api?method=stats.provider.ex&addr=32kcrGh8vFHhgNPJdadHnfdNgqxQKqjnZ1');
echo $string;