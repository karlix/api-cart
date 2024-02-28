<?php

namespace src\Product\Infrastructure;

use Illuminate\Http\Request;
use src\Cart\Application\CreateCartUseCase;
use src\Cart\Domain\ValueObjects\CartId;
use src\Product\Infrastructure\Repositories\EloquentProductRepository;
use src\Product\Application\GetProductsUseCase;
use src\Product\Domain\Contracts\ProductRepositoryContract;

class GetProductsController
{
    private EloquentProductRepository $repository;

    public function __construct(EloquentProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(Request $request) : array
    {
        $getProductsUseCase = new GetProductsUseCase($this->repository);
        return $getProductsUseCase->__invoke();
    }

}
