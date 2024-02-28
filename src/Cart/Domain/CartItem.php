<?php

namespace src\Cart\Domain;


use src\Cart\Domain\ValueObjects\CartItemId;
use src\Cart\Domain\ValueObjects\CartItemQuantity;
use src\Product\Domain\Product;

final class CartItem
{
    private CartItemId $id;
    private Product $product;
    private CartItemQuantity $quantity;

    public function __construct(CartItemId $id, Product $product, CartItemQuantity $quantity)
    {
        $this->id = $id;
        $this->product = $product;
        $this->quantity = $quantity;
    }

    public function updateQuantity(CartItemQuantity $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function id(): CartItemId
    {
        return $this->id;
    }

    public function product(): Product
    {
        return $this->product;
    }

    public function quantity(): CartItemQuantity
    {
        return $this->quantity;
    }

    public function getTotalPrice(): float
    {
        return round($this->product->price()->value() * $this->quantity()->value(), 2);
    }

    public static function create(Product $product, CartItemQuantity $quantity): CartItem
    {
        $id = CartItemId::generate();
        return new self($id, $product, $quantity);
    }

}
