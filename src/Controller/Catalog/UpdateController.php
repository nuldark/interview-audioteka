<?php

namespace App\Controller\Catalog;

use App\Entity\Product;
use App\Messenger\MessageBusAwareInterface;
use App\Messenger\MessageBusTrait;
use App\Messenger\UpdateProduct;
use App\ResponseBuilder\ErrorBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function trim;

#[Route(path: '/products/{product}/update', name: 'product-update', methods: ['PATCH'])]
class UpdateController extends AbstractController implements MessageBusAwareInterface
{
    use MessageBusTrait;

    public function __construct(
        private readonly ErrorBuilder $errorBuilder
    )
    {

    }

    public function __invoke(Product $product, Request $request): Response
    {
        if ($request->request->has('name')) {
            $name = trim($request->get('name'));
            if ($name === '') {
                return new JsonResponse(
                    $this->errorBuilder->__invoke('Invalid name, cannot be empty'),
                    Response::HTTP_UNPROCESSABLE_ENTITY,
                );
            }

            $product->setName($name);
        }

        if ($request->request->has('price')) {
            $price = (int)$request->get('price');
            if ($price < 0) {
                return new JsonResponse(
                    $this->errorBuilder->__invoke('Invalid price, must be greater than zero.'),
                    Response::HTTP_UNPROCESSABLE_ENTITY,
                );
            }

            $product->setPrice($price);
        }

        $this->dispatch(new UpdateProduct($product));

        return new JsonResponse('', Response::HTTP_ACCEPTED);
    }
}