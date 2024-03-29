<?php

ini_set('display_errors', 0);

if (empty($_SERVER["REQUEST_URI"]) || $_SERVER["REQUEST_URI"]!='/metrics'){
    exit();
}

$selenoid_status_url = getenv('SELENOID_STATUS_URL') ?: 'localhost:8080/status';

$json     = json_decode(@file_get_contents($selenoid_status_url), true);
$hostname = gethostname();

if (empty($json) || !array($json)) {
    exit(0);
}

if (isset($json['state'])){
    $data = $json['state'];
}else{
    $data = $json;
}

foreach (array_slice($data, 0,4) as $key => $val){
    echo 'selenoid_state_'.$key.'{hostname="'.$hostname.'"} '.$val.PHP_EOL;
}