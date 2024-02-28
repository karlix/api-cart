<?php

namespace src\Product\Domain\ValueObjects;

use InvalidArgumentException;

final class ProductImage
{
    private string $value;

    /**
     * ProductName constructor.
     * @param string $image
     */
    public function __construct(string $image)
    {
        $this->value = $image;
    }

    public function validate(string $image): void
    {
        if (empty($image)) {
            throw new InvalidArgumentException(
                sprintf('<%s> does not allow the value <%s>.', static::class, $image)
            );
        }
    }
    public function value(): string
    {
        return $this->value;
    }

}
