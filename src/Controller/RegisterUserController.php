<?php

namespace Controller;

use UseCase\RegisterUserUseCase;
use UseCase\RegisterUserRequest;

class RegisterUserController
{
    private RegisterUserUseCase $registerUserUseCase;

    public function __construct(RegisterUserUseCase $registerUserUseCase)
    {
        $this->registerUserUseCase = $registerUserUseCase;
    }

    public function register(): void
    {
        // Suponiendo que se usa PHP nativo para leer el body de la request
        $data = json_decode(file_get_contents('php://input'), true);

        try {
            $requestDTO = new RegisterUserRequest($data['name'], $data['email'], $data['password']);
            $responseDTO = $this->registerUserUseCase->execute($requestDTO);

            header('Content-Type: application/json');
            echo json_encode($responseDTO);
        } catch (\Exception $e) {
            header('Content-Type: application/json', true, 400);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}
