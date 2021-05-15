#!/bin/bash

docker-compose up -d
sleep 3
docker-compose exec app composer install
docker-compose exec app php vendor/bin/doctrine orm:schema-tool:create -q
docker-compose down
