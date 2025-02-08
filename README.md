# GymTracker

GymTracker is a Symfony-based REST API to manage exercises, workouts, and user authentication (JWT). It provides basic CRUD endpoints for storing gym-related data (like exercises), along with JWT-based authentication for secure access.

## Features

- **Symfony 6+** for the backend (MVC structure, services, dependency injection).
- **Docker** for containerized development (PHP, database, Adminer, etc.).
- **JWT Authentication** (LexikJWTAuthenticationBundle) for secure login flow.
- **CRUD** for exercises: create, read (single/all), update, delete.
- **Validation** with Symfony Validator (constraints in entities).
- **Functional Tests** (PHPUnit) covering endpoints with JWT token.
- **Custom CLI Command** to manage entities (optional).
- **Error Handling** returning consistent JSON responses.

## Requirements

- **Docker** and **Docker Compose** installed.
- (Optionally) **Symfony CLI** for local usage, but not mandatory.

## Installation

1. **Clone** this repository:
   ```bash
   git clone https://github.com/your-user/gymtracker.git
   cd gymtracker
2. **Copy** or **create** your .env file (if needed). For Docker, check docker-compose.yml.
3. **Build** and start containers:
   ```bash
   docker compose up -d --build
4. **Install dependencies** (inside container)
   ```bash
   docker compose exec php composer install
5.	**Generate** JWT keys:
   ```bash
   mkdir config/jwt
   openssl genpkey -algorithm RSA -out config/jwt/private.pem - 
   aes256 -pass pass:your_jwt_passphrase
   openssl rsa -pubout -in config/jwt/private.pem -out 
   config/jwt/public.pem -passin pass:your_jwt_passphrase
   ```
6.	**Migrate** database (e.g. PostgreSQL):

```bash
docker compose exec php php bin/console doctrine:database:create
docker compose exec php php bin/console doctrine:migrations:migrate
```
7.	(Optional) **Load** fixtures:
      docker compose exec php php bin/console doctrine:fixtures:load

## Usage

**Running / Stopping Containers**
```
docker compose up -d
docker compose down
docker compose ps
```
**Accessing the App**

•	API at: localhost.

•	Adminer (if configured) at: http://localhost:8080.

## Testing

**PHPUnit Tests**
1.	**Install** test dependencies:
```bash
docker compose exec php composer require --dev symfony/test-pack
```
2. **Run** test:
```bash
docker compose exec php vendor/bin/phpunit
```
## Custom Cli Commands

1. Create new User:
```bash
 php bin/console app:create-user <username>
```

2. Create new Exercise and add it to database

```bash
 php bin/console app:create-exercise <name> <muscle-group> [equipment]
```

## Collection of Endpoints

https://documenter.getpostman.com/view/26475859/2sAYX9keyR
