<?php

namespace src\Product\Application;

use src\Product\Domain\Contracts\ProductRepositoryContract;
use src\Product\Domain\Product;
use src\Product\Domain\ValueObjects\ProductStock;

final class UpdateStockProductUseCase
{
    private ProductRepositoryContract $repository;

    public function __construct(ProductRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke( Product $product, ProductStock $quantity, string $action = null ): void
    {
        if ($action === 'inc') {
            $product->incrementStock($quantity);
        } elseif ($action === 'dec'){
            $product->decrementStock($quantity);
        } else {
            $product->setStock($quantity);
        }

        $this->repository->update($product);
    }

}
