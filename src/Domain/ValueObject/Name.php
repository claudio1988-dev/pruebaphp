<?php

namespace Domain\ValueObject;

use Exception;

class Name
{
    private string $name;

    public function __construct(string $name)
    {
        if (strlen($name) < 3) {
            throw new Exception("El nombre debe tener al menos 3 caracteres");
        }
        $this->name = $name;
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function equals(Name $otroNombre): bool
    {
        return $this->name === $otroNombre->name;
    }
}