<?php

namespace App\Messenger;

use App\Service\Catalog\ProductService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

#[AsMessageHandler]
class AddProductToCatalogHandler implements MessageHandlerInterface
{
    public function __construct(private ProductService $service)
    {
    }

    public function __invoke(AddProductToCatalog $command): void
    {
        $this->service->add($command->name, $command->price);
    }
}