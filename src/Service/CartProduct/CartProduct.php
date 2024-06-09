<?php

namespace App\Service\CartProduct;

use App\Service\Cart\Cart;
use App\Service\Catalog\Product;

interface CartProduct
{
    /**
     * Gets the cart.
     *
     * @return Cart
     */
    public function getCart(): Cart;

    /**
     * Gets the product.
     *
     * @return Product
     */
    public function getProduct(): Product;

    /**
     * Gets the amount.
     *
     * @return int
     */
    public function getAmount(): int;

}