<?php

namespace App\Service\Catalog;

interface ProductService
{
    public function add(string $name, int $price): Product;

    public function update(Product $product): void;

    public function remove(string $id): void;
}