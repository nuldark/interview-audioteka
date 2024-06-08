<?php

namespace App\Service\Cart;

interface CartService
{
    public function addProduct(string $cartId, string $productId, int $amount): void;

    public function removeProduct(string $cartId, string $productId, int $amount): void;

    public function create(): Cart;
}