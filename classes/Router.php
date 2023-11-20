<?php
class Router
{
    /**
     * Поиск соответствия между методом/путём запроса и заданными роутами
     * @param array набор конфигураций роутера 
     */
    static function run(array $routerConfigs)
    {
        $method = mb_strtoupper($_SERVER['REQUEST_METHOD']);
        $path = $_REQUEST['path'] ?? '';
        foreach($routerConfigs as $route) {
            if ($route->method == $method) {
                $res = preg_match($route->path, $path, $matches);
                if ($res === false) {
                    throw new Exception('Incorrect path pattern "' . $route->path . '"');
                } elseif($res > 0) {
                    $className = $route->class;
                    $apiController = new $className($matches, self::getRequestData($method));
                    $apiController->processing();
                    $apiController->render();
                    return;
                }
            }
        }
        (new ApiNotFound([]))->render();
    }


    /**
     * Получение данных запроса
     *
     * @param string $method
     * @return array
     */
    static function getRequestData(string $method): array
    {
        // GET или POST: данные возвращаем как есть
        if ($method === RouterConfig::GET) {
            return $_GET;
        } elseif ($method === RouterConfig::POST) {
            return $_POST;
        }
    
        // PUT, PATCH или DELETE
        $data = [];
        $exploded = explode('&', file_get_contents('php://input'));
    
        foreach($exploded as $pair) {
            $item = explode('=', $pair);
            if (count($item) == 2) {
                $data[urldecode($item[0])] = urldecode($item[1]);
            }
        }
    
        return $data;
    }
}