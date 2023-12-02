# Задача:

_Написать сервис для работы с остатками._
_Минимум 2 метода, списать остатки и получить остатки по товару._

## Требования к коду:

- Язык разработки: PHP.
- Фреймворки и библиотеки можно использовать любые.
- Ограничений по системе хранения данных нет.

---

## Примеры ссылок для тестирования:

| Метод | URL                                                                                  | Body                |
| ----- | ------------------------------------------------------------------------------------ | ------------------- |
| GET   | http://aperturer.temp.swtest.ru/products/8/stock <br>Получить остатки по товару id=8 |                     |
| PATCH | http://aperturer.temp.swtest.ru/products/8/stock <br>Списать остатки 5 ед. с id=8    | {"stock_charge": 5} |
| GET   | http://aperturer.temp.swtest.ru/products <br>Получить список всех товаров            |                     |

## Внешние зависимости:

- [Composer](https://getcomposer.org/) (из которого используется class_loader)
- [harryosmar/php-restful-api-response](https://github.com/harryosmar/php-restful-api-response) (класс формирования данных для ответа)
- [Aura.Di](https://github.com/auraphp/Aura.Di) (Система инъекции зависимостей на базе IoC контейнера)
