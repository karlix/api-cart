<?php

namespace src\Order\Domain\ValueObjects;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid;

final class OrderId
{
    private string $value;

    /**
     * UserId constructor.
     * @param string $id
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
                sprintf('<%s> Invalid OrderId format <%s>.', OrderId::class, $id)
            );
        }
    }

    public static function generate(): OrderId
    {
        return new self(Uuid::uuid4()->toString());
    }
}
