<?php
declare(strict_types = 1);
error_reporting(E_ALL);
ini_set('ignore_repeated_errors', '1'); // true
ini_set('display_errors', '');          // false ¯\_(ツ)_/¯ strict types in 7.6 require it
ini_set('log_errors', '1');
ini_set('error_log', __DIR__ .'/data/log/errors.log'); // все ошибки будем писать в файл

require __DIR__ . '/vendor/autoload.php';

$configFile = 'default.ini'; // можно переопределить в config_selector.php
($cs = __DIR__ . '/config/config_selector.php') && (file_exists($cs)) && (include $cs); // :)
Config::load($configFile);

DBConnect::add(Config::get('database_section'));

Router::findRoute(new Request(), [
    new RouterConfig(Request::GET, '/^product\/(\d*)\/stock$/', ApiGetProduct::class),    // прочитать стоки товара
    new RouterConfig(Request::PUT, '/^product\/(\d*)\/stock$/', ApiUpdateProduct::class), // списать со стоков товара заданное количество
    new RouterConfig(Request::GET, '/^products$/',              ApiProductsList::class),  // показать список всех товаров для разнообразия
]);