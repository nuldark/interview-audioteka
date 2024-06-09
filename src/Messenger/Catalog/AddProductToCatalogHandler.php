<?php

namespace App\Messenger\Catalog;

use App\Service\Catalog\ProductService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

#[AsMessageHandler]
final class AddProductToCatalogHandler implements MessageHandlerInterface
{
    public function __construct(
        private readonly ProductService $service
    )
    {
    }

    /**
     * @param AddProductToCatalog $command
     * @return void
     */
    public function __invoke(AddProductToCatalog $command): void
    {
        $this->service->add(
            $command->name,
            $command->price,
        );
    }
}