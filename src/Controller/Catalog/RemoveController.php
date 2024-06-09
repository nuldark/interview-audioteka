<?php

namespace App\Controller\Catalog;

use App\Entity\Product;
use App\Messenger\Catalog\RemoveProductFromCatalog;
use App\Messenger\MessageBusAwareInterface;
use App\Messenger\MessageBusTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/products/{product}', name: 'product-add', methods: ['DELETE'])]
final class RemoveController extends AbstractController implements MessageBusAwareInterface
{
    use MessageBusTrait;

    public function __invoke(?Product $product): Response
    {
        if ($product !== null) {
            $this->dispatch(new RemoveProductFromCatalog($product));
        }

        return new Response('', Response::HTTP_ACCEPTED);
    }
}
