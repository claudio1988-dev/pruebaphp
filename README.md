# Proyecto PruebaPHP

Este es un proyecto de ejemplo para demostrar el uso de PHP.

## Requisitos

- PHP 8.2 
- Servidor web (Apache, Nginx)

## Instalación

1. Clona el repositorio:
   
    git clone https://github.com/claudio1988-dev/pruebaphp.git

2. Navega al directorio del proyecto:
  
    cd pruebaPHP
    
    composer require doctrine/orm
    composer require --dev phpunit/phpunit
    composer require symfony/cache
    docker-compose build --no-cache
    
3. Configure su servidor web para apuntar al directorio del proyecto.

## SQL
CREATE TABLE users (
    id CHAR(36) NOT NULL PRIMARY KEY COMMENT 'ID único del usuario (UUID)',
    name VARCHAR(255) NOT NULL COMMENT 'Nombre completo del usuario',
    email VARCHAR(255) NOT NULL UNIQUE COMMENT 'Correo electrónico del usuario',
    password VARCHAR(255) NOT NULL COMMENT 'Contraseña del usuario (hash)',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de creación del registro',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Fecha de última actualización del registro'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Tabla de usuarios';
## Uso

Acceda a la aplicación a través de su navegador web en la URL configurada en su servidor web.


