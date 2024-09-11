git clone https://github.com/especializati/setup-docker-laravel.git
git clone https://github.com/laravel/laravel.git 77sol_backend_case
cp -rf setup-docker-laravel/* 77sol_backend_case/
mv 77sol_backend_case/.* ./
mv 77sol_backend_case/* ./
cp .env.example .env

# Random commands
docker compose exec app composer install
docker compose exec app artisan key:generate
docker compose exec app php artisan route:clear
docker compose exec app php artisan route:list
docker compose exec app php artisan migrate

# SETUP SWAGGER
docker compose exec app composer require darkaonline/l5-swagger
docker compose exec app php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"

# GENERATE SWAGGER
docker compose exec app php artisan l5-swagger:generate

# CREATE TABLES
docker compose exec app php artisan make:migration create_clients_table
docker compose exec app php artisan make:migration create_projects_table
# docker compose exec app php artisan make:migration create_equipments_table

docker compose exec app php artisan migrate

# CREATE TESTS
docker compose exec app php artisan make:test CreateClientUseCaseTest --unit
docker compose exec app php artisan make:test ClientRoutesTest
docker compose exec app php artisan make:factory ClientFactory --model=Client
docker compose exec app php artisan make:test UtilsRoutesTest

# RUN TESTS
docker compose exec app php artisan test

# Create custom validator
docker compose exec app php artisan make:rule CpfOrCnpj

# CLEAR cache
docker compose exec app php artisan config:clear
docker compose exec app php artisan cache:clear
docker compose exec app php artisan route:clear

docker compose exec app composer dump-autoload


# update .env
# APP_NAME="77sol backend"
# APP_URL=http://localhost:8989

# DB_CONNECTION=mysql
# DB_HOST=db
# DB_PORT=3306
# DB_DATABASE=laravel
# DB_USERNAME=root
# DB_PASSWORD=root

# CACHE_DRIVER=redis
# QUEUE_CONNECTION=redis
# SESSION_DRIVER=redis

# REDIS_HOST=redis
# REDIS_PASSWORD=null
# REDIS_PORT=6379