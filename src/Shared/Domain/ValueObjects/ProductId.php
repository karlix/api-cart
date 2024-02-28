<?php

namespace src\Shared\Domain\ValueObjects;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid;

final class ProductId
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
                sprintf('<%s> Invalid ProductId format <%s>.', ProductId::class, $id)
            );
        }
    }

    public static function generate(): ProductId
    {
        return new self(Uuid::uuid4()->toString());
    }
}
