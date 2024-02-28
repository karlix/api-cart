<?php

namespace src\Order\Domain;

use src\Order\Domain\ValueObjects\OrderItemId;
use src\Order\Domain\ValueObjects\OrderItemQuantity;
use src\Product\Domain\Product;

final class OrderItem
{
    private OrderItemId $id;
    private Product $product;
    private OrderItemQuantity $quantity;

    public function __construct(OrderItemId $id, Product $product, OrderItemQuantity $cartItemQuantity)
    {
        $this->id = $id;
        $this->product = $product;
        $this->quantity = $cartItemQuantity;
    }

    public function id(): OrderItemId
    {
        return $this->id;
    }

    public function product(): Product
    {
        return $this->product;
    }

    public function quantity(): OrderItemQuantity
    {
        return $this->quantity;
    }

    public static function create(Product $product, OrderItemQuantity $cartItemQuantity): OrderItem
    {
        $id = OrderItemId::generate();
        return new self($id, $product, $cartItemQuantity);
    }

}
