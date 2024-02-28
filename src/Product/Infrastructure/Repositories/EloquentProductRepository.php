<?php

namespace src\Product\Infrastructure\Repositories;

use App\Models\Product as EloquentProductModel;
use src\Product\Domain\Contracts\ProductRepositoryContract;
use src\Product\Domain\Product;
use src\Product\Domain\ValueObjects\ProductImage;
use src\Product\Domain\ValueObjects\ProductName;
use src\Product\Domain\ValueObjects\ProductPrice;
use src\Product\Domain\ValueObjects\ProductStock;
use src\Shared\Domain\ValueObjects\ProductId;

class EloquentProductRepository implements ProductRepositoryContract
{
    private EloquentProductModel $eloquentProductModel;

    public function __construct()
    {
        $this->eloquentProductModel = new EloquentProductModel;
    }

    public function all(): array
    {
        $eloquentProducts = $this->eloquentProductModel->all();
        //devoler array de Products del domain
        return $eloquentProducts->map(function ($eloquentProduct) {
            return new Product(
                new ProductId($eloquentProduct->id),
                new ProductName($eloquentProduct->name),
                new ProductPrice($eloquentProduct->price),
                new ProductStock($eloquentProduct->stock),
                new ProductImage($eloquentProduct->image)
            );
        })->toArray();
    }

    public function find(ProductId $productId): Product
    {
        $eloquentProduct = $this->eloquentProductModel->findOrFail($productId->value());

        return new Product(
            new ProductId($eloquentProduct->id),
            new ProductName($eloquentProduct->name),
            new ProductPrice($eloquentProduct->price),
            new ProductStock($eloquentProduct->stock),
            new ProductImage($eloquentProduct->image)
        );
    }

    public function save(Product $product): void
    {
        $newProduct = $this->eloquentProductModel->create([
            'id' => $product->id()->value(),
            'name' => $product->name()->value(),
            'price' => $product->price()->value(),
            'stock' => $product->stock()->value(),
            'image' => $product->image()->value()
        ]);
    }

    public function update(Product $product): void
    {
        $eloquentCart = $this->eloquentProductModel->findOrFail( $product->id()->value() );
        $eloquentCart->update([
            'name' => $product->name()->value(),
            'price' => $product->price()->value(),
            'stock' => $product->stock()->value(),
            'image' => $product->image()->value()
        ]);
    }

    public function delete(ProductId $productId): void
    {
        //TODO implementar persistencia delete
    }
}
