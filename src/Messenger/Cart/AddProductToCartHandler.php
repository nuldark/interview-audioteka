<?php

namespace App\Messenger\Cart;

use App\Service\Cart\CartService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

#[AsMessageHandler]
class AddProductToCartHandler implements MessageHandlerInterface
{
    public function __construct(private CartService $service)
    {
    }

    public function __invoke(AddProductToCart $command): void
    {
        $this->service->addProduct($command->cartId, $command->productId, $command->amount);
    }
}