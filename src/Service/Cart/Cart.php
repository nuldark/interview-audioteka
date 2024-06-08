<?php

namespace App\Service\Cart;

interface Cart
{
    public function getId(): string;

    public function getTotalPrice();

    public function isFull(): bool;

    public function getProducts(): array;
}
