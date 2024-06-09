<?php

namespace App\Service\Cart;

interface CartService
{

    /**
     * Adds the product to the cart.
     *
     * @param string $cartId
     * @param string $productId
     * @param int $amount
     * @return void
     */
    public function addProduct(string $cartId, string $productId, int $amount): void;

    /**
     * Removes the product from the cart.
     *
     * @param string $cartId
     * @param string $productId
     * @param int $amount
     * @return void
     */
    public function removeProduct(string $cartId, string $productId, int $amount): void;

    /**
     * Creates a new cart.
     *
     * @return Cart
     */
    public function create(): Cart;
}