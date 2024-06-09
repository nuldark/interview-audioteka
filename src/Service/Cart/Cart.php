<?php

namespace App\Service\Cart;

use App\Service\CartProduct\CartProduct;

interface Cart
{
    /**
     * Gets the cart id.
     *
     * @return string
     */
    public function getId(): string;

    /**
     * Gets the total price of the cart.
     *
     * @return int
     */
    public function getTotalPrice(): int;

    /**
     * Checks if cart is full.
     *
     * @return bool
     */
    public function isFull(): bool;

    /**
     * Gets the cart products.
     *
     * @return CartProduct[]
     */
    public function getProducts(): array;
}
