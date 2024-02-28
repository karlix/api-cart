<?php

namespace src\Order\Application;

use src\Cart\Domain\Cart;
use src\Cart\Domain\Contracts\CartRepositoryContract;
use src\Cart\Domain\ValueObjects\CartId;
use src\Order\Domain\Contracts\OrderRepositoryContract;
use src\Order\Domain\Order;
use src\Order\Domain\ValueObjects\OrderItemQuantity;
use src\Order\Domain\ValueObjects\OrderPrice;
use src\Order\Domain\ValueObjects\OrderState;

class CreateOrderFromCartUseCase
{
    private OrderRepositoryContract $repository;

    public function __construct(OrderRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(Cart $cart): void
    {
        $order = Order::create(
            new OrderState(OrderState::$states['PENDING']),
            new OrderPrice($cart->getTotalPrice())
        );

        foreach ($cart->items() as $item) { /** @var $item \src\Cart\Domain\CartItem */
            $order->addProduct(
                $item->product(),
                new OrderItemQuantity($item->quantity()->value())
            );
        }

        $this->repository->save($order);
    }

}
