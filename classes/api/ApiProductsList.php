<?php
declare(strict_types = 1);
/**
 * Контроллер списка товаров
 * GET: /products
 */
class ApiProductsList extends AbstractApi
{
    use ProductModelTrait;

    function run(array $path = [], array $data = []) {
        $limit = 100;
        $offset = 0; // TODO: потом можно добавить нормальный пейджинг по litit/offset или по id between
        $out = [
            'success'     => true,
            'description' => 'Product List',
            'parameters'  => [
                'limit'  => $limit,
                'offset' => $offset,
            ],
            'products' => []
        ];
        foreach($this->productModel->getProductsGen($limit, $offset) as $id => $row) {
            $out['products'][$id] = $row;
        }
        $this->response = $this->response->withArray($out, 200);
    }
}