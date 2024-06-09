<?php

namespace App\Messenger;

use Symfony\Component\Messenger\MessageBusInterface;

interface MessageBusAwareInterface
{

    /**
     * @param MessageBusInterface $bus
     * @return void
     */
    public function setMessageBus(MessageBusInterface $bus): void;

    /**
     * @param object $message
     * @return void
     */
    public function dispatch(object $message): void;
}