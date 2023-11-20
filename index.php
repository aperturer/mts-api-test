<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require __DIR__ . '/vendor/autoload.php';

$configFile = 'default.ini'; // можно переопределить в config_selector.php
($cs = __DIR__ . '/config/config_selector.php') && (file_exists($cs)) && (include $cs); // :)
Config::load($configFile);
DBConnect::add(Config::get('database_section'));

Router::run([
    new RouterConfig(RouterConfig::GET, '/^product\/(\d*)\/stock$/', 'ApiGetProduct'),    // прочитать стоки товара
    new RouterConfig(RouterConfig::POST,'/^product\/(\d*)\/stock$/', 'ApiUpdateProduct'), // списать со стоков товара заданное количество
    new RouterConfig(RouterConfig::GET, '/^products$/', 'ApiProductsList'),               // показать список всех товаров для разнообразия
]);

// TODO: добавить перехват исключений и запись фатальных ошибок в лог вместо output'а
