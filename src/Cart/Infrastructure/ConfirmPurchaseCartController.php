<?php

namespace src\Cart\Infrastructure;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use src\Cart\Application\AddToCartUseCase;
use src\Cart\Application\ConfirmPurchaseCartUseCase;
use src\Cart\Application\CreateCartUseCase;
use src\Cart\Domain\ValueObjects\CartId;
use src\Cart\Infrastructure\Repositories\EloquentCartRepository;
use src\Order\Domain\Contracts\OrderRepositoryContract;
use src\Product\Domain\Contracts\ProductRepositoryContract;

class ConfirmPurchaseCartController
{
    private EloquentCartRepository $cartRepository;
    private OrderRepositoryContract $orderRepository;
    private ProductRepositoryContract $productRepository;

    public function __construct(
        EloquentCartRepository $cartRepository,
        OrderRepositoryContract $orderRepository,
        ProductRepositoryContract $productRepository)
    {
        $this->cartRepository = $cartRepository;
        $this->orderRepository = $orderRepository;
        $this->productRepository = $productRepository;
    }

    public function __invoke(Request $request)
    {
        $validator = Validator::make($request->route()->parameters(), [
            'idCart' => 'required|uuid'
        ],[
            'idCart.required' => 'The idCart is required',
            'idCart.uuid' => 'The idCart must be a valid UUID'
        ]);

        $requestData = $validator->validate();

        $cartId = $requestData['idCart'];

        $confirmPurchaseCartUsecase = new ConfirmPurchaseCartUseCase(
            $this->cartRepository,
            $this->productRepository,
            $this->orderRepository
        );
        $confirmPurchaseCartUsecase->__invoke($cartId);

    }

}
