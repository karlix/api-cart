<?php

namespace src\Cart\Infrastructure;

use Illuminate\Http\Request;
use src\Cart\Domain\Cart;
use src\Cart\Domain\Contracts\CartRepositoryContract;
use src\Order\Domain\Contracts\OrderRepositoryContract;
use src\Product\Domain\Contracts\ProductRepositoryContract;

final class CartService
{
    private CartRepositoryContract $cartRepository;
    private ProductRepositoryContract $productRepository;
    private OrderRepositoryContract $orderRepository;

    public function __construct(
        CartRepositoryContract  $cartRepository,
        OrderRepositoryContract  $orderRepository,
        ProductRepositoryContract $productRepository)
    {
        $this->cartRepository = $cartRepository;
        $this->productRepository = $productRepository;
        $this->orderRepository = $orderRepository;
    }

    public function createCart(Request $request): Cart
    {
        $createCartController = new CreateCartController($this->cartRepository);
        return $createCartController->__invoke($request);
    }

    public function getCart(Request $request): Cart
    {
        $getCartController = new GetCartController( $this->cartRepository );
        return $getCartController->__invoke($request);
    }

    public function deleteCart(Request $request): void
    {
        $deleteCartController = new DeleteCartController( $this->cartRepository );
        $deleteCartController->__invoke($request);
    }

    public function clearCart(Request $request): void
    {
        $deleteCartController = new ClearCartController( $this->cartRepository );
        $deleteCartController->__invoke($request);
    }

    public function addToCart(Request $request): void
    {
        $addToCartController = new AddToCartController(
            $this->cartRepository,
            $this->productRepository
        );
        $addToCartController->__invoke($request);
    }

    public function removeFromCart(Request $request): void
    {
        $removeFromCartController = new RemoveFromCartController(
            $this->cartRepository,
            $this->productRepository
        );
        $removeFromCartController->__invoke($request);
    }

    public function confirmPurchaseCart(Request $request): void
    {
        $confirmPurchaseCartController = new ConfirmPurchaseCartController(
            $this->cartRepository,
            $this->orderRepository,
            $this->productRepository
        );
        $confirmPurchaseCartController->__invoke($request);
    }

    public function getTotalProducts(Request $request): int
    {
        $getTotalProductsCartController = new GetTotalProductsCartController( $this->cartRepository );
        return $getTotalProductsCartController->__invoke($request);
    }

}
