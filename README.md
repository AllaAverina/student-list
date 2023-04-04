# Список студентов
Решение [задачи](https://github.com/codedokode/pasta/blob/master/student-list.md) в учебных целях.

Задание взято [отсюда](https://github.com/Hexlet/ru-test-assignments#%D0%B7%D0%B0%D0%B4%D0%B0%D0%BD%D0%B8%D1%8F).

## Функционал
* Просмотр списка всех студентов
* Сортировка списка по любому столбцу
* Поиск в списке 
* Регистрация студента 
* Зарегистрированный студент может отредактировать информацию о себе

## Требования
* [PHP 8.1+](https://www.php.net/)
* [Composer](https://getcomposer.org/)
* [MySQL](https://www.mysql.com/)
* [Nginx](https://nginx.org/)
* [Docker](https://www.docker.com/), [Docker Compose](https://docs.docker.com/compose/)

## Установка с помощью Docker
1. Клонируйте этот репозиторий:
```sh
git clone https://github.com/AllaAverina/student-list
```
2. Перейдите в папку проекта и выполните:
```sh
docker compose up -d --build
```
3. Затем выполните:
```sh
composer dump-autoload
```
4. Откройте в браузере http://localhost:8000/
5. Для остановки контейнеров используйте:
```sh
docker compose down
```