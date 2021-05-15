#!/bin/bash

docker-compose up -d && \
docker-compose run app composer install && php vendor/bin/doctrine orm:schema-tool:create
docker-compose down
