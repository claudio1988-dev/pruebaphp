<?php

namespace Domain\ValueObject;

use Exception;

class Password
{
    private string $password;

    public function __construct(string $password)
    {
        if (strlen($password) < 8) {
            throw new Exception("La contraseña debe tener al menos 8 caracteres");
        }
        $this->password = $password;
    }

    public function __toString(): string
    {
        return $this->password;
    }

    public function equals(Password $otraPassword): bool
    {
        return $this->password === $otraPassword->password;
    }
}