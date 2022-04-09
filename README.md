### Test App
#### Requirements
* Docker >= 20.10.14
* Docker compose >= 1.29.2
#### Run
1. `cp .env.example .env`
2. `cp docker-compose.override.yml.dist docker-compose.override.yml`
3. `docker-compose up -d --build`