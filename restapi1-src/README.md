## Тестовое на Laravel
Пример каталога каталога на Laravel.

## Для запуска:

настроить .env файлы

- \restapi1-docker\.env.example

- \restapi1-src\.env.example


Запустить контейнер 
- \restapi1-docker\docker-compose.yml

по-умолчанию сайт будет доступен по http://restapi1.localhost/

### Развертываем проект:
```angular2html
composer install

php artisan migrate

php artisan db:seed

php artisan db:seed --class=AllSeeder

php artisan l5-swagger:generate
```

по-умолчанию API документация будет доступна по http://restapi1.localhost/api/documentation

можно посмотреть результат генерации напрямую \restapi1-src\storage\api-docs\api-docs.json 
