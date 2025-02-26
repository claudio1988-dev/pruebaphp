<?php


namespace Domain\ValueObject;

use Domain\Exception\InvalidEmailException;

final class Email
{
    private string $value;

    public function __construct(string $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidEmailException("Formato inválido: $value");
        }
        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
    public function value(): string
    {
        return $this->value;
    }
}