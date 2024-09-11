# 77sol backend case

## Installation
install docker and docker compose https://docs.docker.com/engine/install/<br>
A depender da sua instalação do docker o comando "docker compose" é o correto, se não funcionar, tente "docker-compose"

## Run
```bash
docker compose up -d
```

## Check se todos os container subiram com sucesso
```bash
docker container ls
```
Deveria aparecer algo assim
```bash
8a6f28b069a0   77sol_backend_case-app            "docker-php-entrypoi…"   8 minutes ago   Up 8 minutes           9000/tcp                                        77sol_backend_case-app-1
564eec71c5b3   phpmyadmin/phpmyadmin             "/docker-entrypoint.…"   8 minutes ago   Up 8 minutes           0.0.0.0:8080->80/tcp, :::8080->80/tcp           77sol_backend_case-phpmyadmin-1
5ec1b1a63d49   redis:latest                      "docker-entrypoint.s…"   8 minutes ago   Up 8 minutes           6379/tcp                                        77sol_backend_case-redis-1
0c692bc6d57c   mysql:5.7.22                      "docker-entrypoint.s…"   8 minutes ago   Up 8 minutes           0.0.0.0:3388->3306/tcp, :::3388->3306/tcp       77sol_backend_case-db-1
4c808eb02191   nginx:alpine                      "/docker-entrypoint.…"   8 minutes ago   Up 8 minutes           0.0.0.0:8989->80/tcp, :::8989->80/tcp           77sol_backend_case-nginx-1
```

## Test

### Swagger URL
http://localhost:8989/api/documentation<br>
Se precisar trocar o IP só mudar a variável L5_SWAGGER_CONST_HOST no arquivo .env e rodar o comando abaixo
```bash
docker compose exec app php artisan l5-swagger:generate
```
e tentar acessar novamente

### Run Tests
```bash
docker compose exec app php artisan test
```

## Alguns Links de Referência
https://github.com/namtrt/laravel-10-clean-architecture<br>
https://github.com/especializati/setup-docker-laravel<br>
https://dev.to/bdelespierre/how-to-implement-clean-architecture-with-laravel-2f2i<br>

## Observações
Sei que não é ideal ter o .env no diretório do projeto, mas pensando no avaliador, achei melhor deixar assim para facilitar a execução do projeto.