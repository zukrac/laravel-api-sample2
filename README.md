## Тестовое на Laravel
Пример каталога каталога на Laravel.

Заняло 2.5 вечера, заняло бы 1-1.5 рабочего дня. Не сделан поиск (реализация не сложная).

## Для запуска:

настроить .env файлы

\restapi1-docker\.env.example 

\restapi1-src\.env.example 


## Запустить контейнер

\restapi1-docker\docker-compose.yml

по-умолчанию сайт будет доступен по http://restapi1.localhost/

### Устанавливаем:
composer install

php artisan migrate

php artisan db:seed

php artisan db:seed --class=AllSeeder

php artisan l5-swagger:generate

по-умолчанию документация будет доступна по http://restapi1.localhost/api/documentation

можно посмотреть результат генерации \restapi1-src\storage\api-docs\api-docs.json 
