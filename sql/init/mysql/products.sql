-- создание таблицы товаров
CREATE TABLE IF NOT EXISTS `products` (
    `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Product ID',
    `stock` INT(10) UNSIGNED NOT NULL             COMMENT 'Количество на остатках',
    `name` TEXT                                   COMMENT 'Название', -- Ограничимся названием для наглядности, хотя 
    PRIMARY KEY (`id`)                                                -- по задаче хватило бы и id c quantity
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- наполнение тестовой таблицы товаров
INSERT INTO `products` (`name`, `stock`) VALUES
('Лапшеедка', 97865),
('Спиночесалка', 1733232),
('iPhone SE', 182),
('Москвич-3', 587),
('Москвич-412', 1),
('Конфеты ассорти', 24),
('Светильник IKEA', 6543),
('Калоши чёрные', 843534),
('Подкрадули красные', 18),
('Сумка abibas', 45352),
('Чайник Bosh', 324),
('Чашка синяя', 324234),
('Набор карандашей', 2342),
('Кресло офисное', 3);

