<?php

namespace App\Messenger;

use Symfony\Component\Messenger\MessageBusInterface;

trait MessageBusTrait
{
    private ?MessageBusInterface $messageBus = null;

    /**
     * @param MessageBusInterface $bus
     * @return void
     */
    public function setMessageBus(MessageBusInterface $bus): void
    {
        $this->messageBus = $bus;
    }

    /**
     * @param object $message
     * @return void
     */
    public function dispatch(object $message): void
    {
        $this->messageBus->dispatch($message);
    }
}