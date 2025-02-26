<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use App\Infrastructure\Persistence\DoctrineUserRepository;
use Domain\User\Entity\User;
use PHPUnit\Framework\TestCase;

class DoctrineUserRepositoryTest extends TestCase
{
    private $entityManager;
    private $repository;

    protected function setUp(): void
    {
        $paths = [__DIR__ . 'src/Domain/Entity']; // Ajusta la ruta si es necesario
        $isDevMode = true;

        $dbParams = [
            'driver'   => 'pdo_mysql',
            'host'     => 'mysql',  // Nombre del servicio en Docker
            'dbname'   => 'prueba_db',
            'user'     => 'root',
            'password' => 'root',
            'charset'  => 'utf8'
        ];

        $config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
        $this->entityManager = EntityManager::create($dbParams, $config);

        // Crear el repositorio con el EntityManager
        $this->repository = new DoctrineUserRepository($this->entityManager);
    }

    public function testSaveAndFindUser()
    {
        $user = new User("123", "John Doe", "john@example.com");
        $this->repository->save($user);

        $retrievedUser = $this->repository->findById($user->getId());
        $this->assertNotNull($retrievedUser);
        $this->assertEquals("John Doe", $retrievedUser->getName());
    }
}
