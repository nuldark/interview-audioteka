<?php

namespace App\Controller\Cart;

use App\Entity\Cart;
use App\Entity\Product;
use App\Messenger\AddProductToCart;
use App\Messenger\MessageBusAwareInterface;
use App\Messenger\MessageBusTrait;
use App\Repository\CartRepository;
use App\ResponseBuilder\ErrorBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cart/{cart}/{product}", methods={"PUT"}, name="cart-add-product")
 */
class AddProductController extends AbstractController implements MessageBusAwareInterface
{
    use MessageBusTrait;

    public function __construct(
        private ErrorBuilder $errorBuilder,
    ) { }

    public function __invoke(Request $request, Cart $cart, Product $product): Response
    {
        $amount = (int) $request->get('amount', 1);

        if ($cart->isFull($amount)) {
            return new JsonResponse(
                $this->errorBuilder->__invoke('Cart is full.'),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $this->dispatch(new AddProductToCart($cart->getId(), $product->getId(), $amount));

        return new Response('', Response::HTTP_ACCEPTED);
    }
}
