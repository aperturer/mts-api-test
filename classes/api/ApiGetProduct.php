<?php
declare(strict_types = 1);
/**
 * Котроллер API стоков товара
 * GET: /product/12/stock
 */
class ApiGetProduct extends AbstractApi
{
    use ProductModelTrait;

    function run() {
        $productId = $this->path[1] ?? 0;
        if(!$productId) {
            $this->error404();
        } else {
            $stock = $this->productModel->getStock(intval($productId));
            if ($stock === null) {
                $this->error404();
            } else {
                $data = [
                    'stock' => $stock,
                ];
                $this->response = $this->response->withArray($data, 200);
            }
        }
    }
}