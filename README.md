### Test App
#### Requirements
* Docker >= 20.10.14
* Docker compose >= 1.29.2
#### Run
1. `cp ./app/.env.example ./app/.env`
2. `cp docker-compose.override.yml.dist docker-compose.override.yml`
3. `docker-compose up -d --build`
4. `docker-compose exec php_fpm composer install`
5. `docker-compose exec php_fpm bin/console doctrine:migrations:migrate`
#### Documentation
[http://localhost/api/doc/](http://localhost/api/doc/) - API документация