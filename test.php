<?php

require __DIR__ . '/packages/default/notifier/vendor/autoload.php';

$args = [
     // check chat id: https://api.telegram.org/bot{token}/getUpdates
     'dsn' => 'telegram://...:...@default?channel=-...',

     'text' => implode(PHP_EOL, [
         '<b>hello</b>',
         'world',
     ]),
];

$client = new \GuzzleHttp\Client();

$url = 'https://faas-fra1-afec6ce7.doserverless.co/api/v1/web/fn-e885d530-9581-4dfc-8993-2b82c6a78291/default/notifier';

$response = $client->post($url, [
    'json' => $args,
]);

$responseBody = $response->getBody()->getContents();
$responseCode = $response->getStatusCode();

echo $responseBody . PHP_EOL;
