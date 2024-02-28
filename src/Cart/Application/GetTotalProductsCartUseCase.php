<?php

namespace src\Cart\Application;

use src\Cart\Domain\Exceptions\CartException;
use src\Cart\Domain\Contracts\CartRepositoryContract;
use src\Cart\Domain\ValueObjects\CartId;

final class GetTotalProductsCartUseCase
{
    private CartRepositoryContract $repository;

    public function __construct(CartRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(string $idCart): int
    {
        $cartId = new CartId($idCart);

        $cart = $this->repository->find($cartId);
        if($cart === null) {
            throw new CartException('Cart not found');
        }

        return $cart->getTotalProducts();
    }
}
