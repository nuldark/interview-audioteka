<?php

namespace App\ResponseBuilder;

use App\Service\Cart\Cart;

class CartBuilder
{
    public function __invoke(Cart $cart): array
    {
        $data = [
            'total_price' => $cart->getTotalPrice(),
            'products' => []
        ];

        foreach ($cart->getProducts() as $product) {
            $data['products'][] = [
                'id' => $product->getProduct()->getId(),
                'name' => $product->getProduct()->getName(),
                'price' => $product->getProduct()->getPrice(),
                'amount' => $product->getAmount(),
            ];
        }

        return $data;
    }
}
