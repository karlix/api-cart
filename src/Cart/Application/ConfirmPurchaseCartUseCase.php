<?php

namespace src\Cart\Application;

use src\Cart\Domain\Cart;
use src\Cart\Domain\Exceptions\CartException;
use src\Cart\Domain\Contracts\CartRepositoryContract;
use src\Cart\Domain\ValueObjects\CartId;
use src\Order\Application\CreateOrderFromCartUseCase;
use src\Order\Domain\Contracts\OrderRepositoryContract;
use src\Order\Infrastructure\Repositories\EloquentOrderRepository;
use src\Product\Application\UpdateStockProductUseCase;
use src\Product\Domain\Contracts\ProductRepositoryContract;
use src\Product\Domain\ValueObjects\ProductStock;

final class ConfirmPurchaseCartUseCase
{
    private CartRepositoryContract $cartRepository;
    private OrderRepositoryContract $orderRepository;
    private ProductRepositoryContract $productRepository;

    public function __construct(
        CartRepositoryContract $cartRepository,
        ProductRepositoryContract $productRepository,
        OrderRepositoryContract $orderRepository)
    {
        $this->cartRepository = $cartRepository;
        $this->orderRepository = $orderRepository;
        $this->productRepository = $productRepository;
    }

    public function __invoke(string $idCart): void
    {
        $cart = $this->getCart($idCart);

        $createOrderFromCartUseCase = new CreateOrderFromCartUseCase($this->orderRepository);
        $createOrderFromCartUseCase->__invoke($cart);

        $updateStockProductUseCase = new UpdateStockProductUseCase($this->productRepository);
        foreach ($cart->items() as $itemCart){ /** @var $itemCart \src\Cart\Domain\CartItem */
            $product = $itemCart->product();
            $updateStockProductUseCase->__invoke(
                $product,
                new ProductStock($itemCart->quantity()->value()),
                'dec'
            );
        }

        $clearCartUseCase = new ClearCartUseCase($this->cartRepository);
        $clearCartUseCase->__invoke($idCart);
    }

    private function getCart(string $idCart): Cart
    {
        $cartId = new CartId($idCart);
        $cart = $this->cartRepository->find($cartId);
        if($cart === null) {
            throw new CartException('Cart not found');
        }
        return $cart;
    }
}
