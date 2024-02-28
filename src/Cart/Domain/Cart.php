<?php

namespace src\Cart\Domain;


use src\Cart\Domain\ValueObjects\CartId;
use src\Cart\Domain\ValueObjects\CartItemQuantity;
use src\Product\Domain\Product;

final class Cart
{
    private CartId $id;
    private array $cartItems;

    public function __construct(CartId $id)
    {
        $this->id = $id;
        $this->cartItems = [];
    }

    public function id(): CartId
    {
        return $this->id;
    }

    public function items(): array
    {
        return $this->cartItems;
    }

    public function addProduct(Product $product, CartItemQuantity $quantity): void
    {

        $this->cartItems[$product->id()->value()] = CartItem::create($product, $quantity);
    }

    public function removeProduct(Product $product): void
    {
        unset($this->cartItems[$product->id()->value()]);
    }

    public function getTotalProducts(): int
    {
        return array_reduce($this->cartItems, function ($carry, $item) {
            $carry += $item->quantity()->value();
            return $carry;
        }, 0);
    }

    public function clear(): void
    {
        $this->cartItems = [];
    }

    public function getTotalPrice(): float
    {
        return array_reduce($this->cartItems, function ($carry, $item) { //** @var $item CartItem */
            $carry += $item->product()->price()->value() * $item->quantity()->value();
            $carry = round($carry, 2);
            return $carry;
        }, 0);
    }


    public static function create(): Cart
    {
        $id = CartId::generate();
        return new self($id);
    }

}
