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
