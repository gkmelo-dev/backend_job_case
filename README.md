# 77sol backend case

## Installation
install docker and docker compose https://docs.docker.com/engine/install/<br>
A depender da sua instalação do docker, o comando "docker compose" é o correto, se não funcionar, tente "docker-compose"

## Run
```bash
docker compose up -d
```

## Test

### Swagger URL
http://localhost:8989/api/documentation<br>
Se precisar trocar o IP só mudar a variável L5_SWAGGER_CONST_HOST no arquivo .env e rodar o comando abaixo
```bash
docker compose exec app php artisan l5-swagger:generate
```

### Run Tests
```bash
docker compose exec app php artisan test
```

## Alguns Links de Referência
https://github.com/namtrt/laravel-10-clean-architecture
https://github.com/especializati/setup-docker-laravel
https://dev.to/bdelespierre/how-to-implement-clean-architecture-with-laravel-2f2i

## Observações
Sei que não é ideal ter o .env no diretório do projeto, mas pensando no avaliador, achei melhor deixar assim para facilitar a execução do projeto.