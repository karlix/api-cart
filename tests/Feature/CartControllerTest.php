<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use src\Cart\Domain\Cart;
use src\Cart\Infrastructure\Repositories\EloquentCartRepository;
use Tests\TestCase;

class CartControllerTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_can_create_cart()
    {
        $response = $this->post('api/cart');
        $response->assertStatus(201);
        $this->assertDatabaseHas('carts', [
            'id' => $response->json('cart.id'),
        ]);
    }

    /** @test */
    public function it_can_get_cart()
    {
        $cart = Cart::create();

        $repository = new EloquentCartRepository();
        $repository->save($cart);

        $idCart = $cart->id()->value();
        $response = $this->get('api/cart/'.$idCart);
        $response->assertStatus(201);
        $this->assertEquals($idCart, $response->json('cart.id'));
    }

    /** @test */
    public function it_can_delete_cart()
    {
        $cart = Cart::create();

        $repository = new EloquentCartRepository();
        $repository->save($cart);

        $idCart = $cart->id()->value();
        $response = $this->delete('api/cart/'.$idCart);
        $response->assertStatus(204);
        $this->assertDatabaseMissing('carts', [
            'id' => $idCart,
        ]);
    }

    /** @test */
    public function it_can_clear_cart()
    {
        $cart = Cart::create();

        $repository = new EloquentCartRepository();
        $repository->save($cart);

        $idCart = $cart->id()->value();
        $response = $this->put('api/cart/'.$idCart.'/clear');
        $response->assertStatus(204);
        $this->assertDatabaseMissing('cart_items', [
            'cart_id' => $idCart,
        ]);
    }

}
