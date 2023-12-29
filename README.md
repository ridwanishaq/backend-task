# Containerized Laravel Application on Apache server

## Installation in local
1. Clone the <b>repo</b>
2. Change the configuration
3. Build the images by running: <b>docker-compose build</b>
4. Start the containers: <b>docker-compose up -d</b>

## Executing Artisan command in container:
- $ docker-compose exec service-name php artisan migrate:status
