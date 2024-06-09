<?php

namespace App\Repository;

use App\Entity\CartProduct;
use App\Service\Cart\Cart;
use App\Service\Cart\CartService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Ramsey\Uuid\Uuid;

final class CartRepository implements CartService
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    )
    {
    }

    /**
     * @inheritDoc
     */
    public function addProduct(string $cartId, string $productId, int $amount): void
    {
        $cart = $this->entityManager->find(\App\Entity\Cart::class, $cartId);
        $product = $this->entityManager->find(\App\Entity\Product::class, $productId);

        $cartProduct = $this->entityManager->getRepository(CartProduct::class)
            ->findOneBy([
                'cart' => $cart->getId(),
                'product' => $product->getId()
            ]);

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

    /**
     * @inheritDoc
     */
    public function removeProduct(string $cartId, string $productId, int $amount): void
    {
        $cart = $this->entityManager->find(\App\Entity\Cart::class, $cartId);
        $product = $this->entityManager->find(\App\Entity\Product::class, $productId);

        if ($cart->hasProduct($product)) {
            $cart->removeProduct($product, $amount);

            $this->entityManager->persist($cart);
            $this->entityManager->flush();
        }
    }

    /**
     * @inheritDoc
     */
    public function create(): Cart
    {
        $cart = new \App\Entity\Cart(Uuid::uuid4()->toString());

        $this->entityManager->persist($cart);
        $this->entityManager->flush();

        return $cart;
    }
}