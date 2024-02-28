<?php

namespace src\Order\Domain\ValueObjects;

use InvalidArgumentException;

final class OrderState
{
    private int $value;

    public static $states = [
        'PENDING' => 1,
        'COMPLETED' => 2,
        'CANCELED' => 3
    ];

    /**
     * UserId constructor.
     * @param int $id
     * @throws InvalidArgumentException
     */
    public function __construct(int $state)
    {
        $this->validate($state);
        $this->value = $state;
    }

    /**
     * @param int $id
     * @throws InvalidArgumentException
     */
    private function validate(int $state): void
    {
        $options = array(
            'options' => array(
                'min_range' => 1,
                'max_range' => 3
            )
        );

        if (!filter_var($state, FILTER_VALIDATE_INT, $options)) {
            throw new InvalidArgumentException(
                sprintf('<%s> does not allow the value <%s>.', OrderState::class, $state)
            );
        }
    }

    public function value(): int
    {
        return $this->value;
    }

}
