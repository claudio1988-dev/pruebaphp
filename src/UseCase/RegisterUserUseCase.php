<?php
// src/UseCase/RegisterUserUseCase.php
namespace UseCase;

use Domain\Entity\User;
use Domain\Repository\UserRepositoryInterface;
use Domain\ValueObject\UserId;
use Domain\ValueObject\Name;
use Domain\ValueObject\Email;
use Domain\ValueObject\Password;
use Domain\Exception\UserAlreadyExistsException;
use Domain\Event\UserRegisteredEvent;
use DateTimeImmutable;

class RegisterUserUseCase
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(RegisterUserRequest $request): UserResponseDTO
    {
        // Validar si el email ya está en uso
        if ($this->userRepository->findByEmail($request->email)) {
            throw new UserAlreadyExistsException("El email ya se encuentra en uso");
        }

        // Crear los Value Objects (asumiendo que en sus constructores se validan los datos)
        $userId   = new UserId(); // Implementa la generación de ID único
        $name     = new Name($request->name);
        $email    = new Email($request->email);
        $password = new Password($request->password); // Aquí se debe aplicar el hash internamente

        // Crear la entidad User
        $user = new User($userId, $name, $email, $password, new DateTimeImmutable());

        // Persistir el usuario
        $this->userRepository->save($user);

        // Disparar el evento de dominio (puedes implementar un dispatcher o listener)
        $event = new UserRegisteredEvent($user);
        // Por ejemplo: EventDispatcher::dispatch($event);

        // Retornar la respuesta
        return new UserResponseDTO(
            (string) $user->getId(),
            (string) $user->getName(),
            (string) $user->getEmail(),
            $user->getCreatedAt()->format('Y-m-d H:i:s')
        );
    }
}
