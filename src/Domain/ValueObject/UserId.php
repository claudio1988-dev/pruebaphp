<?php
declare(strict_types=1);

namespace Domain\ValueObject;

use Ramsey\Uuid\Uuid;

final class UserId
{
    private string $value;

    public function __construct(string $value = null)
    {
        $this->value = $value ?? Uuid::uuid4()->toString();
    }

    public function value(): string
    {
        return $this->value;
    }
}