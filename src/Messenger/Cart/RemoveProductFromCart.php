<?php

namespace App\Messenger\Cart;

final class RemoveProductFromCart
{
    public function __construct(
        public readonly string $cartId,
        public readonly string $productId,
        public readonly int    $amount
    )
    {
    }
}