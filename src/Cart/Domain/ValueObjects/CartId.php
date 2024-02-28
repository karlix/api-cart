<?php

namespace src\Cart\Domain\ValueObjects;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid;
use src\Shared\Domain\ValueObjects\ProductId;

final class CartId
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
                sprintf('<%s> Invalid CartId format <%s>.', CartId::class, $id)
            );
        }
    }

    public static function generate(): CartId
    {
        return new self(Uuid::uuid4()->toString());
    }
}
