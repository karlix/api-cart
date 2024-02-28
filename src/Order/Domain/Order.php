<?php

namespace src\Order\Domain;

use src\Order\Domain\ValueObjects\OrderId;
use src\Order\Domain\ValueObjects\OrderItemQuantity;
use src\Order\Domain\ValueObjects\OrderPrice;
use src\Order\Domain\ValueObjects\OrderState;
use src\Product\Domain\Product;
use src\Shared\Domain\ValueObjects\ProductId;

final class Order
{
    private OrderId $id;
    private array $items;
    private OrderState $state;
    private OrderPrice $price;

    public function __construct(OrderId $id, OrderPrice $price, OrderState $state)
    {
        $this->id = $id;
        $this->state = $state;
        $this->price = $price;
        $this->items = [];
    }

    public function id(): OrderId
    {
        return $this->id;
    }

    public function state(): OrderState
    {
        return $this->state;
    }

    public function price(): OrderPrice
    {
        return $this->price;
    }

    public function items(): array
    {
        return $this->items;
    }

    public function addProduct(Product $product, OrderItemQuantity $orderItemQuantity): void
    {
        $idProduct = $product->id()->value();
        $this->items[$idProduct] = OrderItem::create($product, $orderItemQuantity);
    }

    public function removeProduct(Product $product): void
    {
        $idProduct = $product->id()->value();
        unset($this->items[$idProduct]);
    }

    public static function create( OrderState $orderState, OrderPrice $orderPrice ): Order
    {
        $id = OrderId::generate();
        return new self($id, $orderPrice, $orderState);
    }

}
