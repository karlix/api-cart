<?php

namespace src\Cart\Domain\ValueObjects;

use InvalidArgumentException;

final class CartItemQuantity
{
    private int $value;

    /**
     * UserId constructor.
     * @param int $quantity
     * @throws InvalidArgumentException
     */
    public function __construct(int $quantity)
    {
        $this->validate($quantity);
        $this->value = $quantity;
    }

    /**
     * @param int $id
     * @throws InvalidArgumentException
     */
    private function validate(int $quantity): void
    {
        $options = array(
            'options' => array(
                'min_range' => 0,
            )
        );

        if (!filter_var($quantity, FILTER_VALIDATE_INT, $options)) {
            throw new InvalidArgumentException(
                sprintf('<%s> does not allow the value <%s>.', CartItemQuantity::class, $quantity)
            );
        }
    }

    public function value(): int
    {
        return $this->value;
    }

}
