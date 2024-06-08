<?php

namespace App\Service\CartProduct;

use App\Service\Cart\Cart;
use App\Service\Catalog\Product;

interface CartProduct
{
    public function getCart(): Cart;

    public function getProduct(): Product;

    public function getAmount(): int;

}