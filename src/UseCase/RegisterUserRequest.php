<?php
// src/UseCase/RegisterUserRequest.php
namespace UseCase;

class RegisterUserRequest
{
    public string $name;
    public string $email;
    public string $password;

    public function __construct(string $name, string $email, string $password)
    {
        $this->name     = $name;
        $this->email    = $email;
        $this->password = $password;
    }
}
