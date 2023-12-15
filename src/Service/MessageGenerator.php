<?php

namespace App\Service;

use Psr\Log\LoggerInterface;

class MessageGenerator
{
    private array $messages = [
        "Bonjour comment allez vous aujourd'hui ?",
        "Il fait vraiment beau en ce moment !",
        "Bientôt les fêtes de noël, c'est toujours un moment un peu magique",
        "Le gras c'est la vie"
    ];

    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly array $extraMessages
    ){}

    public function getHappyMessage(): string
    {

        $messages = array_merge($this->messages, $this->extraMessages);

        $index = rand(0, count($messages)-1);

        $message = $messages[$index];
        $this->logger->info($message);

        return $message;
    }
}
