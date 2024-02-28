<?php

namespace src\Product\Domain\ValueObjects;

use InvalidArgumentException;

final class ProductPrice
{
    private float $value;

    /**
     * ProductPrice constructor.
     * @param float $price
     * @throws InvalidArgumentException
     */
    public function __construct(float $price)
    {
        $this->validate($price);
        $this->value = $price;
    }

    /**
     * @param float $price
     * @throws InvalidArgumentException
     */
    private function validate(float $price): void
    {
        $options = array(
            'options' => array(
                'min_range' => 0,
            )
        );

        if (!filter_var($price, FILTER_VALIDATE_FLOAT, $options)) {
            throw new InvalidArgumentException(
                sprintf('<%s> does not allow the value <%s>.', ProductPrice::class, $price)
            );
        }
    }

    public function value(): float
    {
        return $this->value;
    }
}
