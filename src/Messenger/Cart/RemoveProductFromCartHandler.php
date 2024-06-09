<?php

namespace App\Messenger\Cart;

use App\Service\Cart\CartService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

#[AsMessageHandler]
final class RemoveProductFromCartHandler implements MessageHandlerInterface
{
    public function __construct(private readonly CartService $service)
    {
    }

    /**
     * @param RemoveProductFromCart $command
     * @return void
     */
    public function __invoke(RemoveProductFromCart $command): void
    {
        $this->service->removeProduct(
            $command->cartId,
            $command->productId,
            $command->amount
        );
    }
}
