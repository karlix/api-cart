<?php

namespace src\Cart\Infrastructure;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use src\Cart\Application\ClearCartUseCase;
use src\Cart\Application\CreateCartUseCase;
use src\Cart\Application\DeleteCartUseCase;
use src\Cart\Domain\ValueObjects\CartId;
use src\Cart\Infrastructure\Repositories\EloquentCartRepository;

class ClearCartController
{
    private EloquentCartRepository $repository;

    public function __construct(EloquentCartRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(Request $request)
    {
        $validator = Validator::make($request->route()->parameters(), [
            'idCart' => 'required|uuid'
        ],[
            'idCart.required' => 'The idCart is required',
            'idCart.uuid' => 'The idCart must be a valid UUID'
        ]);
        $validatedData = $validator->validate();

        $idCart = $validatedData['idCart'];

        $clearCartUseCase = new ClearCartUseCase($this->repository);
        $clearCartUseCase->__invoke($idCart);
    }

}
