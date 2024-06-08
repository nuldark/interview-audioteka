<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use UnexpectedValueException;

#[ORM\Entity]
class CartProduct implements \App\Service\CartProduct\CartProduct
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Cart::class, cascade: ['persist'], inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private Cart $cart;

    #[ORM\ManyToOne(targetEntity: Product::class, cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private Product $product;

    #[ORM\Column(type: 'integer')]
    private int $amount = 1;

    public function __construct(Cart $cart, Product $product, int $amount)
    {
        $this->cart = $cart;
        $this->product = $product;
        $this->amount = $amount;
    }

    public function getCart(): Cart
    {
        return $this->cart;
    }

    public function setCart(Cart $cart): self
    {
        $this->cart = $cart;
        return $this;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        if ($amount < 0) {
            throw new UnexpectedValueException("Amount must be greater than 0");
        }

        $this->amount = $amount;
        return $this;
    }

    public function equals(Product $product): bool
    {
        return $product->getId() === $this->getProduct()->getId();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): self
    {
        $this->product = $product;
        return $this;
    }
}