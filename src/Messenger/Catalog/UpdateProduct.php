<?php

namespace App\Messenger\Catalog;

use App\Entity\Product;

final class UpdateProduct
{
    public function __construct(
        public readonly Product $product
    )
    {

    }
}