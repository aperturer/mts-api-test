<?php
declare(strict_types = 1);

class Router
{
    protected Request $request;

    function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Поиск соответствия между методом/путём запроса и заданными маршрутами 
     *
     * @param Request $request     - Объект запроса
     * @param array $routerConfigs - Набор конфигураций роутера
     * @return array
     */
    function route(array $routerConfigs): array
    {
        foreach($routerConfigs as $route) {
            if ($route->method == $this->request->getMethod()) {
                $res = preg_match($route->path, $this->request->getPath(), $matches);
                if ($res === false) {
                    throw new Exception('Incorrect path pattern "' . $route->path . '"');
                } elseif($res > 0) {
                    if ($this->request->getData() === null) {
                        return [ApiError::class, 'error400', [[
                            'required'  => 'Json format body',
                            'input_data'=> $this->request->getBody(),
                        ]]];
                    }
                    // $className = $route->class;
                    // $apiController = new $className($matches, $this->request->getData());
                    // $apiController->run();
                    return [$route->class, 'run', [$matches, $this->request->getData()]];
                }
            }
        }
        return [ApiError::class, 'error404', []];
    }
}