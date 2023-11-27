<?php

declare(strict_types=1);
/**
 * Котроллер API стоков товара
 * GET: /product/12/stock
 */
class ApiGetProduct extends AbstractApi
{
    use ProductModelTrait;

    public function run(array $path = [], array $data = [])
    {
        $productId = $path[1] ?? 0;
        if (!$productId) {
            $this->error404();
        } else {
            $stock = $this->productModel->getStock(intval($productId));
            if ($stock === null) {
                $this->error404();
            } else {
                $out = [
                    'stock' => $stock,
                ];
                $this->response = $this->response->withArray($out, 200);
            }
        }
    }
}
