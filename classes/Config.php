<?php

declare(strict_types=1);
/** 
 * Точка хранения конфигурации в системе. Не синглтон, так что можно менять под тесты например
 * Конфигурация читается из ini файла и хранится в виде массива, отдавая по get запрошенную секцию (которая тоже массив)
 */
class Config
{
    private const CONFIG_PATH = __DIR__ . '/../config/';
    private static $data;

    /**
     * Загрузка конфигурации из заданного ini-файла
     * @param string $configFileName - имя файла, из которого читается конфиг
     */
    public static function load(string $configFileName)
    {
        self::$data = parse_ini_file(self::CONFIG_PATH . $configFileName, true, INI_SCANNER_TYPED);

        if (!isset(self::$data)) {
            throw new Exception('Config not loaded');
        } elseif (!isset(self::$data['main'])) {
            throw new Exception('No required main section');
        }
        $db = self::$data['main']['database'] ?? '';
        if (!$db || !isset(self::$data[$db])) {
            throw new Exception("No database section in config");
        }
    }

    /**
     * Вернуть данные по ключу из секции main или весь массив данных активной секции базы данных, выбранной в main/database
     * @param string $offset - ключ, по которому запрашиваются данные из секции main, либо database_section, отдающий всю секцию бд 
     * @return mixed
     */
    public static function get(string $offset)
    {
        switch ($offset) {
            case 'database_section':
                return self::$data[self::$data['main']['database']];
            default:
                if (!isset(self::$data['main'][$offset])) {
                    throw new Exception("No key '$offset' in config main section");
                } else return self::$data['main'][$offset];
        }
    }
}
