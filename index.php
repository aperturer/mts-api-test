<?php

declare(strict_types=1);

use Aura\Di\ContainerBuilder;

require __DIR__ . '/vendor/autoload.php'; // Composer class autoloader

// Базовая инициализация
require __DIR__ . '/config/init.php';

// Настройка контейнера
$builder = new ContainerBuilder();
$di = $builder->newInstance($builder::AUTO_RESOLVE);
$di->params[Router::class]['request'] = $di->lazyNew(Request::class);
$di->setters['ProductModelTrait']['setProductModel'] = $di->lazyNew(ProductModel::class);

// Бизнес-логика
$router = $di->newInstance(Router::class);
list($class, $method, $params) = $router->route([
    new RouterConfig(Request::GET, '/^product\/(\d*)\/stock$/', ApiGetProduct::class),    // прочитать стоки товара
    new RouterConfig(Request::PUT, '/^product\/(\d*)\/stock$/', ApiUpdateProduct::class), // списать со стоков товара заданное количество
    new RouterConfig(Request::GET, '/^products$/',              ApiProductsList::class),  // показать список всех товаров для разнообразия
]);

$apiController = $di->newInstance($class);
$apiController->$method(...$params);
