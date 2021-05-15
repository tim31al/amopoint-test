#!/bin/bash

docker-compose up -d && \
docker-compose exec app composer install
docker-compose exec app php vendor/bin/doctrine orm:schema-tool:create
docker-compose down
