<?php

namespace App\Repository;

use App\Service\Catalog\Product;
use App\Service\Catalog\ProductProvider;
use App\Service\Catalog\ProductService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Ramsey\Uuid\Uuid;

final class ProductRepository implements ProductProvider, ProductService
{
    private EntityRepository $repository;

    public function __construct(
        private readonly EntityManagerInterface $entityManager
    )
    {
        $this->repository = $this->entityManager->getRepository(\App\Entity\Product::class);
    }

    /**
     * @inheritDoc
     */
    public function getProducts(int $page = 0, int $count = 3): iterable
    {
        return $this->repository->createQueryBuilder('p')
            ->orderBy('p.createdAt', 'DESC')
            ->setMaxResults($count)
            ->setFirstResult($page * $count)
            ->getQuery()
            ->getResult();
    }

    /**
     * @inheritDoc
     */
    public function getTotalCount(): int
    {
        return $this->repository->createQueryBuilder('p')
            ->select('count(p.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * @inheritDoc
     */
    public function exists(string $productId): bool
    {
        return $this->repository->find($productId) !== null;
    }

    /**
     * @inheritDoc
     */
    public function add(string $name, int $price): Product
    {
        $product = new \App\Entity\Product(Uuid::uuid4(), $name, $price);

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        return $product;
    }

    /**
     * @inheritDoc
     */
    public function update(Product $product): void
    {
        $this->entityManager->persist($product);
        $this->entityManager->flush();
    }

    /**
     * @inheritDoc
     */
    public function remove(Product $product): void
    {
        $this->entityManager->remove($product);
        $this->entityManager->flush();
    }
}
