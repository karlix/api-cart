<?php

namespace src\Cart\Infrastructure;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use src\Cart\Application\CreateCartUseCase;
use src\Cart\Application\GetCartUseCase;
use src\Cart\Domain\Cart;
use src\Cart\Infrastructure\Repositories\EloquentCartRepository;

class GetCartController
{
    private EloquentCartRepository $repository;

    public function __construct(EloquentCartRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(Request $request) : Cart
    {
        $validator = Validator::make($request->route()->parameters(), [
            'idCart' => 'required|uuid'
        ],[
            'idCart.required' => 'The idCart is required',
            'idCart.uuid' => 'The idCart must be a valid UUID'
        ]);
        $validatedData = $validator->validate();

        $cartId = $validatedData['idCart'];

        $getCartUseCase = new GetCartUseCase($this->repository);
        $newCart = $getCartUseCase->__invoke($cartId);

        return $newCart;
    }

}
