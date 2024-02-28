<?php

namespace src\Product\Application;

use src\Product\Domain\Contracts\ProductRepositoryContract;

final class GetProductsUseCase
{
    private ProductRepositoryContract $repository;

    public function __construct(ProductRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(): array
    {
        return $this->repository->all();
    }

}
