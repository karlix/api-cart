<?php

namespace src\Cart\Application;

use src\Cart\Domain\Cart;
use src\Cart\Domain\Contracts\CartRepositoryContract;
use src\Cart\Domain\ValueObjects\CartId;

final class DeleteCartUseCase
{

    private CartRepositoryContract $repository;

    public function __construct(CartRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(string $cartId)
    {
        $id = new CartId($cartId);
        $this->repository->delete($id);
    }

}
