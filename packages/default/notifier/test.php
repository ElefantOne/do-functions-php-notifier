<?php

error_reporting(E_ALL & ~E_DEPRECATED);

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/index.php';

$args = [
    // check chat id: https://api.telegram.org/bot{token}/getUpdates
    'dsn' => 'telegram://...:...@default?channel=-...',
    'text' => implode(PHP_EOL, [
        '<b>hello</b>',
        'world',
    ]),
];

$response = main($args);

echo "Response:\n";

print_r($response);

$memory_usage = memory_get_usage();
$memory_usage = (string) (($memory_usage / 1024) / 1024);

echo 'Memory usage: ' . $memory_usage . " MB\n";
