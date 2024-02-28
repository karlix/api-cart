<?php

namespace src\Cart\Infrastructure;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use src\Cart\Application\AddToCartUseCase;
use src\Cart\Application\CreateCartUseCase;
use src\Cart\Application\RemoveFromCartUseCase;
use src\Cart\Domain\ValueObjects\CartId;
use src\Cart\Infrastructure\Repositories\EloquentCartRepository;
use src\Product\Infrastructure\Repositories\EloquentProductRepository;

class RemoveFromCartController
{
    private EloquentCartRepository $cartRepository;
    private EloquentProductRepository $productRepository;

    public function __construct(EloquentCartRepository $cartRepository, EloquentProductRepository $productRepository)
    {
        $this->cartRepository = $cartRepository;
        $this->productRepository = $productRepository;
    }

    public function __invoke(Request $request)
    {
        $requestData = $request->validate([
            'idProduct' => 'required|uuid',
            'quantity' => 'nullable|integer',
        ], [
            'idProduct.required' => 'The idProduct is required',
            'idProduct.uuid' => 'The idProduct must be a valid UUID',
        ]);

        $validator = Validator::make($request->route()->parameters(), [
            'idCart' => 'required|uuid'
        ],[
            'idCart.required' => 'The idCart is required',
            'idCart.uuid' => 'The idCart must be a valid UUID'
        ]);
        $routeParamsData = $validator->validate();

        $productId = $requestData['idProduct'];
        $quantity = isset($requestData['quantity']) ? (int) $requestData['quantity'] : null;
        $cartId = $routeParamsData['idCart'];

        //$quantity = $quantity === 0 ? null : $quantity;
        echo $quantity;

        // pot haver 2 casos, que es quedi a 0 i s'ha de borrar la linia o que per aqui vingui 0 (quantity = null) i s'hagi de borrar la linia

        $removeFromCartUsecase = new RemoveFromCartUseCase($this->cartRepository, $this->productRepository);
        $removeFromCartUsecase->__invoke($cartId, $productId, $quantity);
    }

}
