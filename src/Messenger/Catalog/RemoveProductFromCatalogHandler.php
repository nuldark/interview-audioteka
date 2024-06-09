<?php

namespace App\Messenger\Catalog;

use App\Service\Catalog\ProductService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

#[AsMessageHandler]
final class RemoveProductFromCatalogHandler implements MessageHandlerInterface
{
    public function __construct(
        private readonly ProductService $service
    )
    {
    }

    /**
     * @param RemoveProductFromCatalog $command
     * @return void
     */
    public function __invoke(RemoveProductFromCatalog $command): void
    {
        $this->service->remove($command->product);
    }
}
