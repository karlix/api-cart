<?php

namespace src\Cart\Application;

use src\Cart\Domain\Cart;
use src\Cart\Domain\Contracts\CartRepositoryContract;
use src\Cart\Domain\ValueObjects\CartId;

class CreateCartUseCase
{

    private CartRepositoryContract $repository;

    public function __construct(CartRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(): CartId
    {
        $cart = Cart::create();
        $this->repository->save($cart);
        return $cart->id();
    }

}
