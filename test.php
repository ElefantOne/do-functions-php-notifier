<?php

require __DIR__ . '/packages/default/notifier/vendor/autoload.php';

// Constants
const OK = 1;

const HTTP_OK = 200;

const ERROR = -1;

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
    // Config
    'connect_timeout' => 20,
    'read_timeout' => 20,
    'timeout' => 30,
    // The data
    'json' => $args,
]);

$responseBody = $response->getBody()->getContents();
$responseCode = $response->getStatusCode();

if (HTTP_OK !== $responseCode) {
    echo "Something went wrong!\n";

    exit(1);
}

echo "HTTP call was successful!\n";

$parsedData = json_decode($response->getBody(), true);
$response = $parsedData['response'];

switch ($response['status']) {
    case OK:
        echo "Notification sent successfully!\n";
        break;
    case ERROR:
        echo "Notification failed to send!\n";
        break;
    default:
        echo "Something went wrong!\n";
        break;
}
