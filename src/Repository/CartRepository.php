<?php

namespace App\Repository;

use App\Entity\CartProduct;
use App\Entity\Product;
use App\Service\Cart\Cart;
use App\Service\Cart\CartService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Ramsey\Uuid\Uuid;

class CartRepository implements CartService
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function getProducts(string $cartId): array
    {
        return $this->entityManager->getRepository(CartProduct::class)
            ->findBy(['cart' => $cartId]);
    }

    public function addProduct(string $cartId, string $productId, int $amount): void
    {
        $cart = $this->entityManager->find(\App\Entity\Cart::class, $cartId);
        $product = $this->entityManager->find(Product::class, $productId);

        if ($cart && $product) {
            $cartProduct = $this->entityManager->getRepository(CartProduct::class)
                ->findOneBy(['cart' => $cartId, 'product' => $productId]);

            if ($cartProduct === NULL) {
                $cartProduct = new CartProduct($cart, $product, $amount);
            }

            $cartProduct->setAmount($amount);

            if ($cart->isFull()) {
                throw new Exception('Cart is full.');
            }

            $this->entityManager->persist($cartProduct);
            $this->entityManager->flush();
        }
    }

    public function removeProduct(string $cartId, string $productId, int $amount): void
    {
        $cart = $this->entityManager->find(\App\Entity\Cart::class, $cartId);
        $product = $this->entityManager->find(Product::class, $productId);

        if ($cart->hasProduct($product)) {
            $cart->removeProduct($product, $amount);

            $this->entityManager->persist($cart);
            $this->entityManager->flush();
        }
    }

    public function create(): Cart
    {
        $cart = new \App\Entity\Cart(Uuid::uuid4()->toString());

        $this->entityManager->persist($cart);
        $this->entityManager->flush();

        return $cart;
    }
}