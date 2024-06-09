<?php

namespace App\Messenger\Catalog;

use App\Service\Catalog\ProductService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

#[AsMessageHandler]
final class UpdateProductHandler implements MessageHandlerInterface
{
    public function __construct(
        private readonly ProductService $productService
    )
    {

    }

    /**
     * @param UpdateProduct $command
     * @return void
     */
    public function __invoke(UpdateProduct $command): void
    {
        $this->productService->update($command->product);
    }
}