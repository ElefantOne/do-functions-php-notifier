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

$url = 'https://faas-fra1-afec6ce7.doserverless.co/api/v1/web/fn-d162e87e-b749-4ae7-ac9c-1a295057435a/default/notifier';

$response = $client->post($url, [
    'json' => $args,
]);

$responseBody = $response->getBody()->getContents();
$responseCode = $response->getStatusCode();

echo $responseBody . PHP_EOL;
