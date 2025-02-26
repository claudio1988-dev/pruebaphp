<?php
// tests/ValueObject/EmailTest.php
use PHPUnit\Framework\TestCase;
use Domain\ValueObject\Email;
use Domain\Exception\InvalidEmailException;

class EmailTest extends TestCase
{
    public function testValidEmail(): void
    {
        $email = new Email("user@example.com");
        $this->assertEquals("user@example.com", (string)$email);
    }

    public function testInvalidEmail(): void
    {
        $this->expectException(InvalidEmailException::class);
        new Email("correo-invalido");
    }
}
