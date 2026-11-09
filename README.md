Lorelvis Santos 20251020

# Hola mundo con PHP, MySQL y Docker Compose

Aplicación web de ejemplo que muestra **¡Hola, mundo!** y consulta MySQL para confirmar que la conexión funciona.

## Requisitos

- Docker
- Docker Compose v2 (`docker compose`)

## Ejecutar

Desde la raíz del proyecto:

```bash
docker compose up --build
```

Abre [http://localhost:8081](http://localhost:8081). La página muestra el nombre de la base de datos y la hora consultada desde MySQL cuando la conexión es exitosa. Puedes cambiar el puerto en el host definiendo `APP_PORT` antes de ejecutar Compose.

Para detener los servicios:

```bash
docker compose down
```

Los datos de MySQL se conservan en el volumen `mysql_data`. Para eliminarlos también:

```bash
docker compose down -v
```

## Estructura

```text
.
├── Dockerfile
├── docker-compose.yml
└── src/
    └── index.php
```

`app` ejecuta PHP con Apache y la extensión PDO MySQL. `db` ejecuta MySQL 8.4; Compose espera a que el chequeo de salud de MySQL pase antes de iniciar la aplicación.

Las credenciales del archivo Compose son únicamente para esta práctica local. Cámbialas y usa secretos apropiados antes de desplegar en un entorno real.
