# Highload Laravel

[![PHP Version](https://img.shields.io/badge/php-8.1+-blue.svg)](https://www.php.net/releases/8.1/)
[![Laravel Version](https://img.shields.io/badge/laravel-10.x-green.svg)](https://laravel.com/)
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)

## Overview

Highload Laravel is a scalable, modular Laravel backend platform designed for high-performance applications.  
It uses Domain-Driven Design (DDD), Doctrine ORM, event-driven architecture with RabbitMQ, and async media compression.

## Features

- Domain-Driven Design (DDD) architecture
- RabbitMQ queue for asynchronous jobs
- Media upload, storage, and compression (images & videos)
- REST API with pagination and relations
- Doctrine ORM integration for flexible DB access
- Clear service layer for business logic

## Requirements

- PHP 8.1+
- Composer
- Docker & Docker Compose (recommended)
- RabbitMQ server
- MySQL/PostgreSQL supported by Doctrine

## Installation

```bash
git clone https://github.com/HarAlb/highload-laravel.git
cd highload-laravel
cp .env.example .env
composer install
php artisan key:generate
php artisan doctrine:migrations:migrate
docker-compose up -d
```

## Usage

- Use API endpoints to manage posts, media, and more.  
- Media files are compressed asynchronously via RabbitMQ jobs.  
- Paginated data responses include medias and their compressed children.  
- Extend domain services for your business logic.

## Project Structure

- `/src/Domain` — Core domain entities  
- `/src/Application` — Application services and DTOs  
- `/src/Infrastructure` — Repositories, queue jobs, and implementation details  
- `/src/Shared` — Shared utilities and libraries  
- `/routes/api.php` — API routes  
- `/docker` — Docker and RabbitMQ configs

