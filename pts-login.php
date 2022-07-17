<?php

$config = require_once './config.php';

ini_set('memory_limit', '512M');

$mobile =  $config['user']['mobile'];

$rows = [];
for ($i = 0; $i < $config['user']['num']; $i++) {
    $mobile += 1;
    $rows[] = sprintf('%s,123123', $mobile);
}

$table = "mobile,password\r\n";
$table .= implode("\r\n", $rows);

file_put_contents('./data/' . date('Y-m-d') . '_pts-login.csv', $table);

echo 'success';
