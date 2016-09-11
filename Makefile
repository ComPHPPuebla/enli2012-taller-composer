SHELL = /bin/bash

.PHONY: install env

env:
	@echo "Copying default settings for the containers.."
	@cp .env.sh.example .env.sh
	@echo "Do not forget to set your Github token in '.env.sh'"

install:
	@echo "Generating files to match the host User and Group IDs for the container..."
	@source .env.sh; rm -f step-1/list-books.php; CONTAINER_VARS='$$CONTAINERS_PREFIX:$$DB_USER:$$DB_PASSWORD:$$DB_NAME'; envsubst "$$CONTAINER_VARS" < "containers/templates/list-books.php.template" > "step-1/list-books.php";
	@source .env.sh; rm -f step-1/show-book-detail.php; CONTAINER_VARS='$$CONTAINERS_PREFIX:$$DB_USER:$$DB_PASSWORD:$$DB_NAME'; envsubst "$$CONTAINER_VARS" < "containers/templates/show-book-detail.php.template" > "step-1/show-book-detail.php";
	@source .env.sh; rm -f containers/config/.pdo.env; CONTAINER_VARS='$$CONTAINERS_PREFIX:$$DB_USER:$$DB_PASSWORD:$$DB_NAME'; envsubst "$$CONTAINER_VARS" < "containers/templates/.pdo.env.template" > "containers/config/.pdo.env";
	@source .env.sh; rm -f containers/config/.db.env; CONTAINER_VARS='$$CONTAINERS_PREFIX:$$DB_USER:$$DB_PASSWORD:$$DB_NAME'; envsubst "$$CONTAINER_VARS" < "containers/templates/.db.env.template" > "containers/config/.db.env";
	@source .env.sh; rm -f Dockerfile; CONTAINER_VARS='$$HOST_USER_ID:$$HOST_GROUP_ID:$$HOST_USER'; envsubst "$$CONTAINER_VARS" < "containers/templates/Dockerfile.template" > "Dockerfile";
	@source .env.sh; rm -f containers/config/group.sh; CONTAINER_VARS='$$HOST_GROUP_ID:$$HOST_USER'; envsubst "$$CONTAINER_VARS" < "containers/templates/group.sh.template" > "containers/config/group.sh";
	@source .env.sh; rm -f containers/config/.bashrc; CONTAINER_VARS='$$CONTAINER_HOSTNAME'; envsubst "$$CONTAINER_VARS" < "containers/templates/.bashrc.template" > "containers/config/.bashrc";
	@source .env.sh; rm -f docker-compose.yml; CONTAINER_VARS='$$CONTAINERS_PREFIX:$$DB_ROOT_PASSWORD:$$DB_USER:$$DB_PASSWORD:$$DB_NAME'; envsubst "$$CONTAINER_VARS" < "containers/templates/docker-compose.yml.template" > "docker-compose.yml";
	@source .env.sh; rm -f containers/config/auth.json; CONTAINER_VARS='$$GITHUB_TOKEN'; envsubst "$$CONTAINER_VARS" < "containers/templates/auth.json.template" > "containers/config/auth.json";
	@source .env.sh; rm -f containers/images/db/database.sql; CONTAINER_VARS='$$DB_NAME'; envsubst "$$CONTAINER_VARS" < "containers/templates/database.sql.template" > "containers/images/db/database.sql";
	@echo "Copying configuration files..."
	@cp containers/config/.pdo.env step-2.1/.env
	@cp containers/config/.pdo.env step-3/.env
	@cp containers/config/.pdo.env step-4/.env
	@cp containers/config/.db.env step-5.1/.env
	@cp containers/config/.db.env step-6/.env
	@cp containers/config/.db.env step-7/.env
	@cp containers/config/.db.env step-8.1/.env
	@echo "Building container and seeding database..."
	@docker-compose up -d
