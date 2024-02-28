<?php

namespace src\Cart\Domain\Contracts;

use src\Cart\Domain\ValueObjects\CartItemQuantity;
use src\Product\Domain\Product;
use src\Cart\Domain\Cart;
use src\Cart\Domain\ValueObjects\CartId;

interface CartRepositoryContract
{
    public function find(CartId $cartId): ?Cart;

    public function save(Cart $cart): CartId;

    public function update(Cart $cart): void;

    public function delete(CartId $cartId): void;

    public function clear(CartId $cartId): void;

    public function addToCart(Cart $cart, Product $product, CartItemQuantity $cartItemQuantity): void;

    public function removeFromCart(Cart $cart, Product $product, ?CartItemQuantity $cartItemQuantity = null): void;
}
