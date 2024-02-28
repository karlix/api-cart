<?php


use PHPUnit\Framework\TestCase;
use src\Cart\Domain\Cart;
use src\Cart\Domain\ValueObjects\CartItemQuantity;
use src\Product\Domain\Product;
use src\Product\Domain\ValueObjects\ProductImage;
use src\Product\Domain\ValueObjects\ProductName;
use src\Product\Domain\ValueObjects\ProductPrice;
use src\Product\Domain\ValueObjects\ProductStock;

class CartTest extends TestCase
{

    public function test_can_add_product_to_cart(): void
    {
        $cart = Cart::create();
        $product = Product::create(
            new ProductName('Test Product 1'),
            new ProductPrice(10.00),
            new ProductStock(50),
            new ProductImage('test.jpg')
        );
        $quantity = new CartItemQuantity(2);

        $cart->addProduct($product, $quantity);

        $this->assertCount(1, $cart->items());
    }


    public function test_can_clear_cart(): void
    {
        $cart = Cart::create();
        $product = Product::create(
            new ProductName('Test Product 1'),
            new ProductPrice(10.00),
            new ProductStock(50),
            new ProductImage('test.jpg')
        );
        $quantity = new CartItemQuantity(2);
        $cart->addProduct($product, $quantity);

        $cart->clear();

        $this->assertCount(0, $cart->items());
    }

    public function it_can_add_and_remove_product()
    {
        $cart = Cart::create();
        $product = Product::create(
            new ProductName('Test Product 1'),
            new ProductPrice(10.00),
            new ProductStock(50),
            new ProductImage('test.jpg')
        );
        $quantity = new CartItemQuantity(2);

        $cart->addProduct($product, $quantity);

        $this->assertCount(1, $cart->items());

        $cart->removeProduct($product);

        $this->assertCount(0, $cart->items());
    }

    /** @test */
    public function it_can_get_total_products()
    {
        $cart = Cart::create();
        $product1 = Product::create(
            new ProductName('Test Product 1'),
            new ProductPrice(10.00),
            new ProductStock(50),
            new ProductImage('test.jpg')
        );
        $quantity1 = new CartItemQuantity(2);

        $product2 = Product::create(
            new ProductName('Test Product 2'),
            new ProductPrice(20.00),
            new ProductStock(50),
            new ProductImage('test.jpg')
        );
        $quantity2 = new CartItemQuantity(3);

        $cart->addProduct($product1, $quantity1);
        $cart->addProduct($product2, $quantity2);

        $this->assertEquals(5, $cart->getTotalProducts());
    }

    /** @test */
    public function it_can_get_total_price()
    {
        $cart = Cart::create();
        $product1 = Product::create(
            new ProductName('Test Product 1'),
            new ProductPrice(10.00),
            new ProductStock(50),
            new ProductImage('test.jpg')
        );
        $quantity1 = new CartItemQuantity(2);

        $product2 = Product::create(
            new ProductName('Test Product 2'),
            new ProductPrice(20.00),
            new ProductStock(50),
            new ProductImage('test.jpg')
        );
        $quantity2 = new CartItemQuantity(3);

        $cart->addProduct($product1, $quantity1);
        $cart->addProduct($product2, $quantity2);

        // Total price = (10 * 2) + (20 * 3) = 80
        $this->assertEquals(80.00, $cart->getTotalPrice());
    }

    /** @test */
    public function it_can_be_created_with_factory_method()
    {
        $cart = Cart::create();

        $this->assertInstanceOf(Cart::class, $cart);
    }

    // crear test para verificar que se puede obtener el total de productos en el carrito
    // crear test para verificar que se puede obtener el total a pagar por los productos en el carrito

}
