<?php

namespace src\Product\Domain\Contracts;

use src\Product\Domain\Product;
use src\Shared\Domain\ValueObjects\ProductId;

interface ProductRepositoryContract
{
    public function all(): array;

    public function find(ProductId $productId): Product;

    public function save(Product $product): void;

    public function update(Product $product): void;

    public function delete(ProductId $productId): void;
}
