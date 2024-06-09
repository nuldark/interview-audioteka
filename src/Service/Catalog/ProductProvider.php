<?php

namespace App\Service\Catalog;

interface ProductProvider
{
    /**
     * Gets the products.
     *
     * @return Product[]
     */
    public function getProducts(int $page = 0, int $count = 3): iterable;

    /**
     * Checks if the product exists.
     *
     * @param string $productId
     * @return bool
     */
    public function exists(string $productId): bool;

    /**
     * Gets the total count of products.
     *
     * @return int
     */
    public function getTotalCount(): int;
}
