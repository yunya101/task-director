# Task Director

## Установка
**Клонирование репозитория**
```
git clone https://yunya101/task-director
```
**Установка необходимых библиотек с помощью composer**
```
cd task-director
composer install
```
## Настройка базы данных

**В файле .env необходимо настроить подключение к базе данных**
```
DB_CONNECTION=
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```
**Создание таблиц(миграция)**
```
php artisan migrate
```