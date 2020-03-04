.DEFAULT_GOAL := help
.PHONY: help
.SILENT:

GREEN  := $(shell tput -Txterm setaf 2)
RESET  := $(shell tput -Txterm sgr0)

test: lint phpcs phpunit phpstan

install:
	composer install --prefer-dist --no-interaction --no-suggest

## Run PHP unit tests
phpunit:
	@echo "${GREEN}Unit tests${RESET}"
	@php bin/phpunit

## Run PHP code sniffer
phpcs:
	@echo "${GREEN}PHP Code Sniffer${RESET}"
	@php vendor/bin/phpcs -p --standard=psr12 --colors src/

## Run PHPStan
phpstan:
	@echo "${GREEN}PHPStan${RESET}"
	@php vendor/bin/phpstan analyse -l 0 src/

## PHP Parallel Lint
lint:
	@echo "${GREEN}PHP Parallel Lint${RESET}"
	@php vendor/bin/parallel-lint src/ tests/

## Fix PHP syntax with code sniffer
fix:
	@php vendor/bin/php-cs-fixer --no-interaction fix

## Test Coverage HTML
coverage:
	@echo "${GREEN}Tests with coverage${RESET}"
	@php bin/phpunit --coverage-html /tmp/coverage
