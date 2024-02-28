<?php

namespace src\Order\Domain\ValueObjects;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid;

final class OrderItemId
{
    private string $value;

    /**
     * UserId constructor.
     * @param int $id
     * @throws InvalidArgumentException
     */
    public function __construct(string $id)
    {
        $this->validate($id);
        $this->value = $id;
    }

    public function value(): string
    {
        return $this->value;
    }

    /**
     * @param string $id
     * @throws InvalidArgumentException
     */
    private function validate(string $id): void
    {
        if (!Uuid::isValid($id)) {
            throw new InvalidArgumentException(
                sprintf('<%s> Invalid OrderItemId format <%s>.', OrderItemId::class, $id)
            );
        }
    }

    public static function generate(): OrderItemId
    {
        return new self(Uuid::uuid4()->toString());
    }
}
