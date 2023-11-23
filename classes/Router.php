<?php
declare(strict_types = 1);

class Router
{
    protected $productModel;
    protected $request;

    function __construct(ProductModelInterface $productModel, Request $request)
    {
        $this->productModel = $productModel;
        $this->request = $request;
    }

    /**
     * Поиск соответствия между методом/путём запроса и заданными маршрутами 
     *
     * @param Request $request     - Объект запроса
     * @param array $routerConfigs - Набор конфигураций роутера
     * @return void
     */
    function route(array $routerConfigs)
    {
        foreach($routerConfigs as $route) {
            if ($route->method == $this->request->getMethod()) {
                $res = preg_match($route->path, $this->request->getPath(), $matches);
                if ($res === false) {
                    throw new Exception('Incorrect path pattern "' . $route->path . '"');
                } elseif($res > 0) {
                    if ($this->request->getData() === null) {
                        (new ApiError($this->productModel))->error400([
                            'required'  => 'Json format body',
                            'input_data'=> $this->request->getBody(),
                        ]);
                        return;
                    }
                    $className = $route->class;
                    $apiController = new $className($this->productModel, $matches, $this->request->getData());
                    $apiController->run();
                    return;
                }
            }
        }
        (new ApiError($this->productModel))->error404();
    }
}