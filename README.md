Laravel Blogs

Стек: [php, laravel, postgres. nginx, docker, docker-compose]

Запуск
```shell
docker-compose up -d --build

docker-compose exec app bash

chmod -R 777 storage

composer install

php artisan key:gen

php artisan migrate
```