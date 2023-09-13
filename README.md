### Install

```bash
docker-compose up --build
```
```bash
 docker-compose exec php-fpm php bin/console do:schema:create
 docker-compose exec php-fpm php bin/console do:fi:lo
```
Open http://localhost:8080
----
