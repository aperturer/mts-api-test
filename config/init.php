<?php
declare(strict_types = 1);

error_reporting(E_ALL);
ini_set('ignore_repeated_errors', '1'); // true
ini_set('display_errors', '');          // false 
ini_set('log_errors', '1');
ini_set('error_log', __DIR__ .'/data/log/errors.log'); // все ошибки будем писать в файл

$configFile = 'default.ini'; // можно переопределить в config_selector.php
($cs = __DIR__ . '/config_selector.php') && (file_exists($cs)) && (include $cs); // выбор конфигурации
Config::load($configFile);

DBConnect::add(Config::get('database_section'));