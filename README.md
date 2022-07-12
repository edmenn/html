# GESTAPP

Sistema para la gestión de los proyectos e inversiones de la Empresa Sarcom S.A.

## Installation
Primeramente hacer una copia del archivo env.example a uno nuevo con el nombre ".env", este archivo .env editarlo y definir las configuraciones con las de la máquina local (usuario, password y nombre de base de datos, entre otros).

Luego instalar las librerías y dependencias del proyecto con Compose.
```bash
composer install
```

Luego utilizar la interfaz de línea de comandos proveída por Laravel para instalar gestapp.

```bash
php artisan migrate
php artisan db:seed
```

## Usage
Para correr el proyecto se ejecuta la siguiente línea de comandos:
```bash
php artisan serve
```