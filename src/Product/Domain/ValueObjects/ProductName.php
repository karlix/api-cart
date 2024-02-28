<?php

namespace src\Product\Domain\ValueObjects;

use InvalidArgumentException;

final class ProductName
{
    private string $value;

    /**
     * ProductName constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->value = $name;
    }

    public function value(): string
    {
        return $this->value;
    }

}
