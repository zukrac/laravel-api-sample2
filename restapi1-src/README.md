## Тестовое на Laravel
Пример каталога каталога на Laravel.

## Для запуска:

- настроить .env файлы
- запустить докер образы \restapi1-docker\docker-compose.yml

### Развертываем проект:
```
cd /var/www/html

composer install

php artisan migrate

php artisan db:seed

php artisan db:seed --class=AllSeeder

php artisan l5-swagger:generate
```

API документация будет доступна по http://restapi1.localhost/api/documentation

можно посмотреть результат генерации напрямую \restapi1-src\storage\api-docs\api-docs.json 
