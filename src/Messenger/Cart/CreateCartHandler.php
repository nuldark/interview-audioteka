<?php

namespace App\Messenger\Cart;

use App\Service\Cart\Cart;
use App\Service\Cart\CartService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

#[AsMessageHandler]
final class CreateCartHandler implements MessageHandlerInterface
{
    public function __construct(
        private readonly CartService $service
    )
    {

    }

    public function __invoke(CreateCart $command): Cart
    {
        return $this->service->create();
    }
}
