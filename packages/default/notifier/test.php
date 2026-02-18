<?php

declare(strict_types=1);

error_reporting(E_ALL & ~E_DEPRECATED);

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/index.php';

$args = [
    // you can find out the CHAT_ID in the output of https://api.telegram.org/bot{token}/getUpdates
    'dsn' => 'telegram://TOKEN@default?channel=CHAT_ID',
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
