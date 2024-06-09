<?php

namespace App\Messenger\Catalog;

use App\Service\Catalog\Product;

final class RemoveProductFromCatalog
{
    public function __construct(
        public readonly Product $product
    )
    {
    }
}