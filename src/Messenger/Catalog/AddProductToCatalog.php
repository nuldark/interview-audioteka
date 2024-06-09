<?php

namespace App\Messenger\Catalog;

final class AddProductToCatalog
{
    public function __construct(
        public readonly string $name,
        public readonly int    $price,
    )
    {
    }
}