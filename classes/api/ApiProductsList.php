<?php
/**
 * Контроллер списка товаров
 * GET: /products
 */
class ApiProductsList extends AbstractApi
{
    function run() {
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
        foreach(ProductModel::getProductsGen($limit, $offset) as $id => $row) {
            $out['products'][$id] = $row;
        }
        $this->response = $this->response->withArray($out, 200);
    }
}