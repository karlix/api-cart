<?php
namespace src\Product\Domain;

use src\Product\Domain\ValueObjects\ProductImage;
use src\Product\Domain\ValueObjects\ProductName;
use src\Product\Domain\ValueObjects\ProductPrice;
use src\Product\Domain\ValueObjects\ProductStock;
use src\Shared\Domain\ValueObjects\ProductId;

final class Product
{
    private ProductId $id;
    private ProductName $name;
    private ProductPrice $price;
    private ProductStock $stock;
    private ProductImage $image;

    public function __construct(ProductId $id, ProductName $name, ProductPrice $price, ProductStock $stock, ProductImage $image)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->stock = $stock;
        $this->image = $image;
    }

    public function id(): ProductId
    {
        return $this->id;
    }

    public function name(): ProductName
    {
        return $this->name;
    }

    public function price(): ProductPrice
    {
        return $this->price;
    }

    public function image(): ProductImage
    {
        return $this->image;
    }

    public function stock(): ProductStock
    {
        return $this->stock;
    }

    public function decrementStock(ProductStock $quantity): void
    {
        $this->stock = new ProductStock($this->stock->value() - $quantity->value());
    }

    public function incrementStock(ProductStock $quantity): void
    {
        $this->stock = new ProductStock($this->stock->value() + $quantity->value());
    }

    public function setStock(ProductStock $quantity): void
    {
        $this->stock = $quantity;
    }

    public static function create( ProductName $name, ProductPrice $price, ProductStock $stock, ProductImage $image): Product
    {
        $id = ProductId::generate();
        return new self($id, $name, $price, $stock, $image);
    }

}
