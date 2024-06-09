<?php

namespace App\Controller\Cart;

use App\Messenger\Cart\CreateCart;
use App\Service\Cart\Cart;
use App\Service\Cart\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/cart', name: 'cart-create', methods: ['POST'])]
final class CreateController extends AbstractController
{
    use HandleTrait;

    public function __construct(
        private readonly CartService $cartService,
        MessageBusInterface          $messageBus
    )
    {
        $this->messageBus = $messageBus;
    }

    public function __invoke(): Response
    {
        /** @var Cart $cart */
        $cart = $this->handle(new CreateCart());

        return new JsonResponse(['cart_id' => $cart->getId()], Response::HTTP_CREATED);
    }
}
