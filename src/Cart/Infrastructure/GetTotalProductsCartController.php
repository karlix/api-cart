<?php

namespace src\Cart\Infrastructure;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use src\Cart\Application\CreateCartUseCase;
use src\Cart\Application\GetTotalProductsCartUseCase;
use src\Cart\Domain\Exceptions\CartException;
use src\Cart\Domain\ValueObjects\CartId;
use src\Cart\Infrastructure\Repositories\EloquentCartRepository;

class GetTotalProductsCartController
{
    private EloquentCartRepository $repository;

    public function __construct(EloquentCartRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(Request $request) : int
    {
        $validator = Validator::make($request->route()->parameters(), [
            'idCart' => 'required|uuid'
        ],[
            'idCart.required' => 'The idCart is required',
            'idCart.uuid' => 'The idCart must be a valid UUID'
        ]);

        $validatedData = $validator->validate();
        $cartId = $validatedData['idCart'];

        $getTotalProductsCartUseCase = new GetTotalProductsCartUseCase($this->repository);
        return $getTotalProductsCartUseCase->__invoke($cartId);
    }

}
