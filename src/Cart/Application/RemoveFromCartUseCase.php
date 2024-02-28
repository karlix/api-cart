<?php

namespace src\Cart\Application;

use src\Cart\Domain\Cart;
use src\Cart\Domain\Exceptions\CartException;
use src\Cart\Domain\ValueObjects\CartItemQuantity;
use src\Product\Domain\Contracts\ProductRepositoryContract;
use src\Product\Domain\Exceptions\ProductException;
use src\Product\Domain\Product;
use src\Shared\Domain\ValueObjects\ProductId;
use src\Cart\Domain\Contracts\CartRepositoryContract;
use src\Cart\Domain\ValueObjects\CartId;

final class RemoveFromCartUseCase
{
    private CartRepositoryContract $cartRepository;
    private ProductRepositoryContract $productRepository;

    public function __construct(CartRepositoryContract $cartRepository, ProductRepositoryContract $productRepository)
    {
        $this->cartRepository = $cartRepository;
        $this->productRepository = $productRepository;
    }

    public function __invoke(string $idCart, string $idProduct, ?int $quantity = null): void
    {
        $cart = $this->getCart($idCart);
        $product = $this->getProduct($idProduct);
        if($quantity !== null) {
            $quantity = new CartItemQuantity($quantity);
        }
        //$cart->removeProduct($product);

        $this->cartRepository->removeFromCart($cart, $product, $quantity);
    }

    private function getCart(string $id): Cart
    {
        $cartId = new CartId($id);

        $cart = $this->cartRepository->find($cartId);
        if($cart === null) {
            throw new CartException('Cart not found');
        }
        return $cart;
    }

    private function getProduct(string $id): Product
    {
        $productId = new ProductId($id);
        $product = $this->productRepository->find($productId);
        if($product === null) {
            throw new ProductException('Product not found');
        }
        return $product;
    }
}
