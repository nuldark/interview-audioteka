<?php

namespace App\Controller\Cart;

use App\Entity\Cart;
use App\Entity\Product;
use App\Messenger\Cart\RemoveProductFromCart;
use App\Messenger\MessageBusAwareInterface;
use App\Messenger\MessageBusTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/cart/{cart}/{product}', name: 'cart-remove-product', methods: ['DELETE'])]
final class RemoveProductController extends AbstractController implements MessageBusAwareInterface
{
    use MessageBusTrait;

    public function __invoke(Request $request, Cart $cart, ?Product $product): Response
    {
        if ($product !== null) {
            $amount = (int)$request->get('amount', 1);
            $this->dispatch(new RemoveProductFromCart($cart->getId(), $product->getId(), $amount));
        }

        return new Response('', Response::HTTP_ACCEPTED);
    }
}
