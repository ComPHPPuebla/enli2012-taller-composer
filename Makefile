SHELL = /bin/bash

.PHONY: install start

install:
	@echo "Generating auth.json file for composer"
	@sed -e s/{{GITHUB_TOKEN}}/$(GITHUB_TOKEN)/ containers/config/auth.dist.json > containers/config/auth.json
	@echo "Building container and seeding database..."
	@docker-compose up -d

start:
	@echo "Starting containers..."
	@docker-compose up -d
	@echo "Loading aliases..."
	@source .alias
