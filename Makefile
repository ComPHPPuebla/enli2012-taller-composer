SHELL = /bin/bash

.PHONY: install start

install:
	@echo "Generating auth.json file for composer"
	@sed -e s/{{GITHUB_TOKEN}}/$(GITHUB_TOKEN)/ containers/config/auth.dist.json > containers/config/auth.json
	@echo "Copying configuration files..."
	@cp step-2.1/.env.example step-2.1/.env
	@cp step-3/.env.example step-3/.env
	@cp step-4/.env.example step-4/.env
	@cp step-5.1/.env.example step-5.1/.env
	@cp step-6/.env.example step-6/.env
	@cp step-7/.env.example step-7/.env
	@cp step-8.1/.env.example step-8.1/.env
	@echo "Building container and seeding database..."
	@docker-compose up -d
