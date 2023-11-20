-- создание очереди заданий
CREATE TABLE IF NOT EXISTS `queue` (
    `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID операции',
    `type` INT(10) UNSIGNED                       COMMENT '1-списание', -- пока других типов не предусмотрено
    `status` INT(10) NOT NULL                     COMMENT '0-новая, 1-взято в работу, 2-успешно обработано, -1-неудачная попытка обработки',
    `data` JSON NOT NULL                          COMMENT 'Данные для обработки'
    PRIMARY KEY (`id`)                                                -- по задаче хватило бы и id c quantity
) ENGINE=InnoDB DEFAULT CHARSET=utf8;