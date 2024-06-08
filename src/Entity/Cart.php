<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use function array_reduce;

#[ORM\Entity]
class Cart implements \App\Service\Cart\Cart
{
    public const CAPACITY = 3;

    #[ORM\Id]
    #[ORM\Column(type: 'uuid', nullable: false)]
    private UuidInterface $id;

    #[ORM\OneToMany(mappedBy: 'cart', targetEntity: CartProduct::class, cascade: ['persist'])]
    private Collection $products;

    public function __construct(string $id)
    {
        $this->id = Uuid::fromString($id);
        $this->products = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id->toString();
    }

    public function addProduct(Product $product, int $amount = 1): self
    {
        $this->products->add(new CartProduct($this, $product, $amount));
        return $this;
    }

    public function removeProduct(Product $product, int $amount = 1): self
    {
        $this->products
            ->filter(static fn(CartProduct $cartProduct) => $cartProduct->equals($product))
            ->map(function (CartProduct $cartProduct) use ($amount) {
                $cartProduct->setAmount($cartProduct->getAmount() - $amount);

                if ($cartProduct->getAmount() === 0) {
                    $this->products->removeElement($cartProduct);
                }
            });

        return $this;
    }

    public function hasProduct(Product $product): bool
    {
        foreach ($this->products as $cartProduct) {
            if ($cartProduct->equals($product)) {
                return true;
            }
        }

        return false;
    }

    public function getTotalPrice(): int
    {
        return array_reduce(
            $this->getProducts(),
            static fn(int $total, CartProduct $cartProduct) => $total + ($cartProduct->getProduct()->getPrice() * $cartProduct->getAmount()),
            0
        );
    }

    public function getProducts(): array
    {
        return $this->products->toArray();
    }

    public function isFull(?int $amount = null): bool
    {
        return array_reduce(
                $this->getProducts(),
                static fn(int $total, CartProduct $cartProduct) => $total + $cartProduct->getAmount(),
                0
            ) + $amount > self::CAPACITY;
    }

}
