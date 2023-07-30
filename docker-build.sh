#!/bin/sh

docker compose down --remove-orphans;
docker compose build;

docker compose up -d;
docker compose exec -it php composer install
docker compose exec -it php php artisan migrate --seed
docker exec -it php composer test
