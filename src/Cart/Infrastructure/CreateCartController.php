<?php

namespace src\Cart\Infrastructure;

use Illuminate\Http\Request;
use src\Cart\Application\CreateCartUseCase;
use src\Cart\Application\GetCartUseCase;
use src\Cart\Domain\Cart;
use src\Cart\Domain\ValueObjects\CartId;
use src\Cart\Infrastructure\Repositories\EloquentCartRepository;

class CreateCartController
{
    private EloquentCartRepository $repository;

    public function __construct(EloquentCartRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(Request $request) : Cart
    {
        $createCartUseCase = new CreateCartUseCase($this->repository);
        $cartid = $createCartUseCase->__invoke();

        $getCartUseCase = new GetCartUseCase($this->repository);
        $newCart = $getCartUseCase->__invoke($cartid->value());

        return $newCart;
    }

}
