<?php
declare(strict_types=1);

use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\ORMSetup; // Usar ORMSetup en lugar de Setup
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\DriverManager; // Importar DriverManager
use App\Infrastructure\Persistence\DoctrineUserRepository;
use Domain\User\Entity\User;
use PHPUnit\Framework\TestCase;

class DoctrineUserRepositoryTest extends TestCase
{
    private $entityManager;
    private $repository;

    protected function setUp(): void
    {
        // Configuración de Doctrine: define las rutas donde se encuentran las entidades y el modo de desarrollo
        $paths = [__DIR__ . '/../../src/Domain/Entity'];
        $isDevMode = true;

        // Usar ORMSetup para crear la configuración
        $config = ORMSetup::createAttributeMetadataConfiguration($paths, $isDevMode);

        // Configuración de la conexión a la base de datos (ajusta los parámetros según tu entorno Docker)
        $connectionParams = [
            'driver'   => 'pdo_mysql',
            'host'     => 'localhost',
            'port'     => 3306,
            'dbname'   => 'prueba_db',
            'user'     => 'root',
            'password' => 'root',
        ];

        // Crear la conexión a la base de datos usando DriverManager
        $connection = DriverManager::getConnection($connectionParams, $config);

        // Crear el EntityManager usando la conexión y la configuración
        $this->entityManager = new EntityManager($connection, $config);

        // Crear el esquema de la base de datos a partir de las entidades
        $schemaTool = new SchemaTool($this->entityManager);
        $metadata = $this->entityManager->getMetadataFactory()->getAllMetadata();
        if (!empty($metadata)) {
            $schemaTool->createSchema($metadata);
        }

        // Instanciar el repositorio concreto de Doctrine
        $this->repository = new DoctrineUserRepository($this->entityManager);
    }

    protected function tearDown(): void
    {
        // Eliminar el esquema para dejar la base de datos limpia entre tests
        $schemaTool = new SchemaTool($this->entityManager);
        $metadata = $this->entityManager->getMetadataFactory()->getAllMetadata();
        if (!empty($metadata)) {
            $schemaTool->dropSchema($metadata);
        }

        $this->entityManager->close();
        $this->entityManager = null;
    }

    public function testSaveAndFindUser(): void
    {
        // Crear un usuario de prueba
        $userId = new UserId('123'); // Asegúrate de que el Value Object UserId acepte un valor o genere uno automáticamente
        $name = new Name('John Doe');
        $email = new Email('john@example.com');
        $password = new Password('ValidP@ssw0rd'); // Se supone que internamente se valida y hashea la contraseña
        $user = new User($userId, $name, $email, $password);

        // Guardar el usuario en la base de datos
        $this->repository->save($user);

        // Recuperar el usuario por su ID y verificar que se guarden los datos
        $retrievedUser = $this->repository->findById($userId);
        $this->assertNotNull($retrievedUser);
        $this->assertEquals((string)$user->getEmail(), (string)$retrievedUser->getEmail());

        // También se puede probar la consulta por email
        $retrievedUserByEmail = $this->repository->findByEmail('john@example.com');
        $this->assertNotNull($retrievedUserByEmail);
        $this->assertEquals((string)$user->getName(), (string)$retrievedUserByEmail->getName());
    }

    public function testDeleteUser(): void
    {
        // Crear otro usuario para probar el borrado
        $userId = new UserId('456');
        $name = new Name('Jose Luis');
        $email = new Email('jose@prueba.com');
        $password = new Password('ValidP@ssw0rd!');
        $user = new User($userId, $name, $email, $password);

        // Guardar el usuario
        $this->repository->save($user);

        // Verificar que el usuario existe
        $this->assertNotNull($this->repository->findById($userId));

        // Eliminar el usuario
        $this->repository->delete($userId);

        // Comprobar que ya no se encuentra el usuario
        $this->assertNull($this->repository->findById($userId));
    }
}