# Path to the docker-compose file
DOCKER_COMPOSE_FILEPATH=.docker/docker-compose.yaml
DOCKER_PHP_CONTAINER=ferrovipath_php
-include Makefile.local

# Start the containers in the background
up:
	docker compose -f $(DOCKER_COMPOSE_FILEPATH) up -d

# Stop the containers
down:
	docker compose -f $(DOCKER_COMPOSE_FILEPATH) down

# Recreate the containers (useful after modifying the Dockerfile)
build:
	docker compose -f $(DOCKER_COMPOSE_FILEPATH) up --build -d

# View the logs of the containers
logs:
	docker compose -f $(DOCKER_COMPOSE_FILEPATH) logs -f

# View the status of the containers
status:
	docker compose -f $(DOCKER_COMPOSE_FILEPATH) ps

# Remove the containers, networks, volumes, and images created by up
clean:
	docker compose -f $(DOCKER_COMPOSE_FILEPATH) down --volumes --remove-orphans

# Restart the containers
restart: down up

# Connect to the PHP container
shell:
	docker exec -it $(DOCKER_PHP_CONTAINER) /bin/bash

# Run composer install
composer-install:
	docker exec $(DOCKER_PHP_CONTAINER) composer install

# Regenerate Composer autoloading
dump-autoload:
	docker exec $(DOCKER_PHP_CONTAINER) composer dump-autoload

# Run Symfony console commands
sf:
	docker exec $(DOCKER_PHP_CONTAINER) php bin/console

# Clear the Symfony cache
cache-clear:
	docker exec $(DOCKER_PHP_CONTAINER) php bin/console cache:clear

# Run database migrations
migrate:
	docker exec $(DOCKER_PHP_CONTAINER) php bin/console doctrine:migrations:migrate --no-interaction

# Run PHPUnit tests
test:
	docker exec $(DOCKER_PHP_CONTAINER) ./vendor/bin/phpunit

js:
	rm -rf public/assets/ ;
	php bin/console asset-map:compile;

db:
	@echo "\033[1;32mSuppression de toute la base de donnée (no panic)\033[0m"
	php bin/console doctrine:database:drop --force --if-exists
	@echo "\033[1;32mRecréation de la nouvelle BDD\033[0m"
	php bin/console doctrine:database:create
	@echo "\033[1;32mSuppression des anciennes migrations\033[0m"
	rm -rf migrations/*.php
	@echo "\033[1;32mRecréation d'une nouvelle migration\033[0m"
	php bin/console make:migration
	@echo "\033[1;32mExécution de la migration\033[0m"
	php bin/console doctrine:migrations:migrate --no-interaction
	@echo "\033[1;32mchargement des fixtures\033[0m"
	php bin/console doctrine:fixtures:load --no-interaction
	@echo "\033[1;32mLa base de donnée à été recréée avec succès !\033[0m"