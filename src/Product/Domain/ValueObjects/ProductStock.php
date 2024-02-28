<?php

namespace src\Product\Domain\ValueObjects;

use InvalidArgumentException;

final class ProductStock
{
    private int $value;

    /**
     * ProductStock constructor.
     * @param int $stock
     * @throws InvalidArgumentException
     */
    public function __construct(int $stock)
    {
        $this->validate($stock);
        $this->value = $stock;
    }

    /**
     * @param int $stock
     * @throws InvalidArgumentException
     */
    private function validate(int $stock): void
    {
        $options = array(
            'options' => array(
                'min_range' => 0,
            )
        );

        if (!filter_var($stock, FILTER_VALIDATE_INT, $options)) {
            throw new InvalidArgumentException(
                sprintf('<%s> does not allow the value <%s>.', static::class, $stock)
            );
        }
    }

    public function value(): int
    {
        return $this->value;
    }
}
