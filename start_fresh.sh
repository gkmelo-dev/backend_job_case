git clone https://github.com/especializati/setup-docker-laravel.git
git clone https://github.com/laravel/laravel.git 77sol_backend_case
cp -rf setup-docker-laravel/* 77sol_backend_case/
mv 77sol_backend_case/.* ./
mv 77sol_backend_case/* ./
cp .env.example .env

# docker compose exec app composer install
# docker compose exec app artisan key:generate
# docker compose exec app php artisan route:clear
docker compose exec app php artisan route:list
# php artisan migrate

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