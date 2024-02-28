<?php

namespace src\Order\Domain\ValueObjects;

use InvalidArgumentException;

final class OrderPrice
{
    private float $value;

    /**
     * UserId constructor.
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
                'min_range' => 0
            )
        );

        if (!filter_var($price, FILTER_VALIDATE_FLOAT, $options)) {
            throw new InvalidArgumentException(
                sprintf('<%s> does not allow the value <%s>.', OrderPrice::class, $price)
            );
        }
    }

    public function value(): float
    {
        return $this->value;
    }

}
