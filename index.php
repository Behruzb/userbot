<?php
require_once 'vendor/autoload.php';

$settings = [
    'app_info' => [
        'api_id' => 721128,
        'api_hash' => '83bb993972326f27ad4e4ef939606e0a',
    ],
    'logger' => [
        'logger_level' => \danog\MadelineProto\Logger::ULTRA_VERBOSE,
    ],
];

$MadelineProto = new \danog\MadelineProto\API($settings);

$MadelineProto->start();

$MadelineProto->setEventHandler('\EventHandler');

class EventHandler extends \danog\MadelineProto\EventHandler
{
    public function onAny($update)
    {
        if ($update['_'] === 'updateNewMessage' && isset($update['message']['message'])) {
            $message = $update['message']['message'];
            $chatID = $update['message']['to_id']['channel_id'] ?? $update['message']['to_id']['user_id'] ?? null;

            if ($chatID && strtolower($message) === 'hello') {
                $this->messages->sendMessage([
                    'peer' => $chatID,
                    'message' => 'Hello there!',
                ]);
            }
        }
    }
}

$MadelineProto->loop(-1);
