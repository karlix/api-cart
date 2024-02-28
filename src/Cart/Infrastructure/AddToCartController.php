<?php

namespace src\Cart\Infrastructure;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use src\Cart\Application\AddToCartUseCase;
use src\Cart\Application\CreateCartUseCase;
use src\Cart\Domain\Exceptions\CartException;
use src\Cart\Domain\ValueObjects\CartId;
use src\Cart\Infrastructure\Repositories\EloquentCartRepository;
use src\Product\Infrastructure\Repositories\EloquentProductRepository;


class AddToCartController
{
    private EloquentCartRepository $cartRepository;
    private EloquentProductRepository $productRepository;

    public function __construct(
        EloquentCartRepository  $cartRepository,
        EloquentProductRepository $productRepository)
    {
        $this->cartRepository = $cartRepository;
        $this->productRepository = $productRepository;
    }

    public function __invoke(Request $request)
    {
        $requestData = $request->validate([
            'idProduct' => 'required|uuid',
            'quantity' => 'required|integer|min:1',
        ], [
            'idProduct.required' => 'The idProduct is required',
            'idProduct.uuid' => 'The idProduct must be a valid UUID',
            'quantity.required' => 'The quantity is required',
            'quantity.integer' => 'The quantity must be an integer',
        ]);

        $validator = Validator::make($request->route()->parameters(), [
            'idCart' => 'required|uuid'
        ],[
            'idCart.required' => 'The idCart is required',
            'idCart.uuid' => 'The idCart must be a valid UUID'
        ]);
        $routeParamsData = $validator->validate();

        $productId = $requestData['idProduct'];
        $quantity = (int) $requestData['quantity'];
        $cartId = $routeParamsData['idCart'];

        $addToCartUsecase = new AddToCartUseCase($this->cartRepository, $this->productRepository);
        $addToCartUsecase->__invoke($cartId, $productId, $quantity);
    }

}
