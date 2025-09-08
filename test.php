<?php

require __DIR__ . '/packages/default/notifier/vendor/autoload.php';

$args = [
    // you can find out the CHAT_ID in the output of https://api.telegram.org/bot{token}/getUpdates
    'dsn' => 'telegram://TOKEN@default?channel=CHAT_ID',
    'text' => implode(PHP_EOL, [
        '<b>hello</b>',
        'world',
    ]),
];

$client = new \GuzzleHttp\Client();

$url = 'https://faas-fra1-afec6ce7.doserverless.co/api/v1/web/fn-98c5a8d3-60ac-4726-89a4-90a3b9e02f5c/default/notifier';

$response = $client->post($url, [
    'json' => $args,
]);

$responseBody = $response->getBody()->getContents();
$responseCode = $response->getStatusCode();

var_dump($responseBody);
