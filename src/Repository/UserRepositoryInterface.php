<?php
// src/Domain/Repository/UserRepositoryInterface.php
namespace Domain\Repository;

use Domain\Entity\User;
use Domain\ValueObject\UserId;

interface UserRepositoryInterface
{
    public function save(User $user): void;
    public function findById(UserId $id): ?User;
    public function findByEmail(string $email): ?User;
    public function delete(UserId $id): void;
}
