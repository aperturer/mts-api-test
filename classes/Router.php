<?php

declare(strict_types=1);

/**
 * Маршрутизатор входящего запроса
 */
class Router
{
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Поиск соответствия между методом/путём запроса и заданными маршрутами 
     *
     * @param Request $request     - Объект запроса
     * @param array $routerConfigs - Набор конфигураций роутера
     * @return array - Кортеж из класса, метода и массива аргументов выбранного роутером апи
     */
    public function route(array $routerConfigs): array
    {
        foreach ($routerConfigs as $route) {
            if ($route->method == $this->request->getMethod()) {
                $res = preg_match($route->path, $this->request->getPath(), $matches);
                if ($res === false) {
                    throw new Exception('Incorrect path pattern "' . $route->path . '"');
                } elseif ($res > 0) {
                    if ($this->request->getData() === null) {
                        return [ApiError::class, 'error400', [[
                            'required'  => 'Json format body',
                            'input_data' => $this->request->getBody(),
                        ]]];
                    }
                    return [$route->class, 'run', [$matches, $this->request->getData()]];
                }
            }
        }
        return [ApiError::class, 'error404', []];
    }
}
