<?php

declare(strict_types=1);

use Symfony\Component\Notifier\Bridge\Telegram\TelegramOptions;
use Symfony\Component\Notifier\Bridge\Telegram\TelegramTransportFactory;
use Symfony\Component\Notifier\Chatter;
use Symfony\Component\Notifier\Message\ChatMessage;
use Symfony\Component\Notifier\Transport\Dsn;

// Statuses
const OK = 1;

const ERROR = -1;

// Error reporting
error_reporting(E_ALL & ~E_DEPRECATED);

/**
 * A wrapper function to return the response.
 *
 * @param array $args Arguments to be returned
 *
 * @return array Response with status and result
 */
function wrap(array $args): array
{
    return ['body' => $args];
}

/**
 * Send notification using Telegram.
 *
 * @param array $args Arguments containing the DSN and text
 *
 * @return array Response with status and result
 */
function main(array $args): array
{
    $requiredArgs = [
        'dsn',
        'text',
    ];

    // Check required arguments
    foreach ($requiredArgs as $arg) {
        if (!array_key_exists($arg, $args) || $args[$arg] === null) {
            return wrap(['error' => sprintf('Please supply %s argument.', $arg)]);
        }
    }

    // Check arguments
    if (!is_string($args['dsn'])) {
        return wrap(['error' => 'Please supply dsn argument as a string.']);
    }

    if (!is_string($args['text'])) {
        return wrap(['error' => 'Please supply text argument as a string.']);
    }

    // Send the message
    $result = send($args['dsn'], $args['text']);

    return wrap(['response' => $result, 'version' => 1]);
}

/**
 * Send the message using Symfony Notifier.
 *
 * @param string $dsn  The DSN for the transport
 * @param string $text The message text
 *
 * @return array Response with status and result
 */
function send(string $dsn, string $text): array
{
    try {
        $transport = (new TelegramTransportFactory())->create(new Dsn($dsn));
        $chatter = new Chatter($transport);
        $chatMessage = new ChatMessage($text);

        $telegramOptions = (new TelegramOptions())
            ->parseMode('HTML')
            ->disableWebPagePreview(true);

        $chatMessage->options($telegramOptions);

        $chatter->send($chatMessage);

        return ['status' => OK];
    } catch (Throwable $e) {
        return ['status' => ERROR, 'result' => sprintf('Failed to send: %s', $e->getMessage())];
    }
}
