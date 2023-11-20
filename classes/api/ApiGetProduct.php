<?php
class ApiGetProduct extends AbstractApi
{
    function processing() {
        $product_id = $this->path[1] ?? 0;
        if(!$product_id) {
            $this->response = $this->response->errorNotFound();
        } else {
            $stock = ProductModel::getStock(intval($product_id));
            if ($stock === null) {
                $this->response = $this->response->errorNotFound();
            } else {
                $data = [
                    'stock' => $stock,
                ];
                $this->response = $this->response->withArray($data, 200);
            }
        }
    }
}