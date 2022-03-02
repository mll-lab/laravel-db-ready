dc-php=$$( [ -f /.dockerenv ] && echo "" || echo "docker-compose exec php")

.PHONY: it
it: vendor fix stan test ## Run all quality tools

.PHONY: help
help: ## Displays this list of targets with descriptions
	@grep -E '^[a-zA-Z0-9_-]+:.*?## .*$$' $(firstword $(MAKEFILE_LIST)) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}'

.PHONY: setup
setup: dc-build vendor ## Setup the local environment

.PHONY: dc-build
dc-build: ## Build the local dev image
	docker-compose build --pull --build-arg USER_ID=$(shell id -u) --build-arg GROUP_ID=$(shell id -g)

.PHONY: up
up: ## Bring up the containers
	[ -f /.dockerenv ] || docker-compose up --detach

.PHONY: shell
shell: up ## Jump into a shell in the php container
	${dc-php} bash

.PHONY: fix
fix: up ## Fix code style
	${dc-php} composer normalize
	${dc-php} vendor/bin/php-cs-fixer fix

.PHONY: stan
stan: up ## Run static analysis
	${dc-php} vendor/bin/phpstan analyse --memory-limit=2048M

.PHONY: test
test: up ## Run PHPUnit tests
	${dc-php} vendor/bin/phpunit

vendor: up composer.json ## Install dependencies through composer
	${dc-php} composer update
