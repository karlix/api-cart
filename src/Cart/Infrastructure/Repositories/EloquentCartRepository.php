<?php

namespace src\Cart\Infrastructure\Repositories;

use App\Models\Cart as EloquentCartModel;
use src\Cart\Domain\ValueObjects\CartItemQuantity;
use src\Product\Domain\Product;
use src\Product\Domain\ValueObjects\ProductImage;
use src\Product\Domain\ValueObjects\ProductName;
use src\Product\Domain\ValueObjects\ProductPrice;
use src\Product\Domain\ValueObjects\ProductStock;
use src\Shared\Domain\ValueObjects\ProductId;
use src\Cart\Domain\Cart;
use src\Cart\Domain\CartItem;
use src\Cart\Domain\Contracts\CartRepositoryContract;
use src\Cart\Domain\ValueObjects\CartId;

class EloquentCartRepository implements CartRepositoryContract
{
    private EloquentCartModel $eloquentCartModel;

    public function __construct()
    {
        $this->eloquentCartModel = new EloquentCartModel;
    }

    public function find(CartId $cartId): ?Cart
    {
        $eloquentCart = $this->eloquentCartModel->findOrFail($cartId->value());

        $cart = new Cart($cartId);

        $eloquentCart->items()->each(function ($item) use ($cart) {

            $cart->addProduct(
                new Product(
                    new ProductId($item->product->id),
                    new ProductName($item->product->name),
                    new ProductPrice($item->product->price),
                    new ProductStock($item->product->stock),
                    new ProductImage($item->product->image)
                ),
                new CartItemQuantity($item->quantity)
            );

        });

        return $cart;
    }

    public function save(Cart $cart): CartId
    {
        $newCart = $this->eloquentCartModel->create([
            'id' => $cart->id()->value()
        ]);

        $newCart->items()->createMany(collect($cart->items())
            ->map(function ($item) use ($cart) { /** @var CartItem $item */
                return [
                    'id' => $item->id()->value(),
                    'cart_id' => $cart->id()->value(),
                    'product_id' => $item->product()->id()->value(),
                    'quantity' => $item->quantity()->value()
                ];
            })
            ->toArray()
        );

        return new CartId($newCart->id);
    }

    public function update(Cart $cart): void
    {
        $eloquentCart = $this->eloquentCartModel->findOrFail( $cart->id()->value() );
        $eloquentCart->items()->delete();
        $eloquentCart->items()->createMany(
            collect($cart->items())
                ->map(function ($item) { /** @var CartItem $item */
                    return [
                        'product_id' => $item->product()->id()->value(),
                        'quantity' => $item->quantity()->value()
                    ];
                })
                ->toArray()
        );
    }

    public function delete(CartId $cartId): void
    {
        $this->eloquentCartModel
            ->findOrFail($cartId->value())
            ->delete();
    }

    public function addToCart(Cart $cart, Product $product, CartItemQuantity $cartItemQuantity): void
    {
        $eloquentCart = $this->eloquentCartModel->findOrFail($cart->id()->value());

        $cartItem = $eloquentCart->items()->where('product_id', $product->id()->value())->get()->first();
        if( $cartItem == null){

            $cartItem = CartItem::create($product, $cartItemQuantity);
            $eloquentCart->items()->create([
                'id' => $cartItem->id()->value(),
                'product_id' => $product->id()->value(),
                'quantity' => $cartItemQuantity->value()
            ]);
        }else{

            $cartItem->increment('quantity', $cartItemQuantity->value());
            //$cartItem->save();
        }

    }

    public function removeFromCart(Cart $cart, Product $product, ?CartItemQuantity $cartItemQuantity = null ): void
    {
        $eloquentCart = $this->eloquentCartModel->findOrFail($cart->id()->value());
        $idProduct = $product->id()->value();
        $eloquentCartItem = $eloquentCart->items()->where('product_id', $idProduct)->first();
        if( $cartItemQuantity == null // caso en que queremos eliminar el CartItem entero
            || ($eloquentCartItem->quantity < $cartItemQuantity->value()) // queremos restar mas cantidad de la que hay
            || (($eloquentCartItem->quantity - $cartItemQuantity->value()) <= 0)) // si el resultado final de quantity sera 0 o menos
        {
            $eloquentCartItem->delete();
            return;
        }

        $eloquentCartItem->decrement('quantity', $cartItemQuantity->value());
    }

    public function clear(CartId $cartId): void
    {
        $cart = $this->eloquentCartModel->findOrFail($cartId->value());
        $cart->items()->delete();
    }
}
