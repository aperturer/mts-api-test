<?php
declare(strict_types = 1);

class Router
{
    /**
     * Поиск соответствия между методом/путём запроса и заданными маршрутами 
     *
     * @param Request $request     - Объект запроса
     * @param array $routerConfigs - Набор конфигураций роутера
     * @return void
     */
    static function findRoute(Request $request, array $routerConfigs)
    {
        foreach($routerConfigs as $route) {
            if ($route->method == $request->method) {
                $res = preg_match($route->path, $request->path, $matches);
                if ($res === false) {
                    throw new Exception('Incorrect path pattern "' . $route->path . '"');
                } elseif($res > 0) {
                    if ($request->requestData === null) {
                        (new ApiError())->error400([
                            'required'  => 'Json format body',
                            'input_data'=> $request->body,
                        ]);
                        return;
                    }
                    $className = $route->class;
                    $apiController = new $className($matches, $request->requestData);
                    $apiController->run();
                    return;
                }
            }
        }
        (new ApiError())->error404();
    }
}