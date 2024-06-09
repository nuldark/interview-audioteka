<?php

namespace App\Service\Catalog;

interface ProductService
{

    /**
     * Adds a new product.
     *
     * @param string $name
     * @param int $price
     * @return Product
     */
    public function add(string $name, int $price): Product;

    /**
     * Updates the product.
     *
     * @param Product $product
     * @return void
     */
    public function update(Product $product): void;

    /**
     * Removes the product.
     *
     * @param Product $product
     * @return void
     */
    public function remove(Product $product): void;
}