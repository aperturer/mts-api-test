<?php
declare(strict_types = 1);
/**
 * Контроллер списания стоков товара
 * PUT: /product/12/stock
 * Списываемое значение нужно передавать в теле запроса в формате JSON так: 
 * {"stock_charge": 5}
 * 
 * TODO: тут не помешала бы авторизация, лог запросов и номер запроса клиента (который он ведёт у себя), 
 * чтобы не повторять успешное списание, на которое он не получил ответ.
 */
class ApiUpdateProduct extends AbstractApi
{
    use ProductModelTrait;

    private $attempts = 3; // число попыток при взаимных блокировках

    function run(array $path = [], array $data = []) {
        $productId = intval($path[1] ?? 0);
        $charge = intval($data['stock_charge'] ?? 0);

        if (!$productId) {
            $this->error404();
        } elseif (!$charge || $charge < 1) {
            $error = isset($data['stock_charge']) ? 
                ['wrong_value' => 'Value stock_charge must be greater than zero'] :
                ['missing_parameter' => 'Required parameter stock_charge is missing in request body'];
            $this->error400($error);
        } else {
            $attempt = $this->attempts; 
            while ($attempt-- && !($success = ProductModel::stockReduce($productId, $charge))) {
                // тут мы окажемся только если что-то пошло не так и есть ещё попытки
                $stock = $this->productModel->getStock($productId);
                if (is_null($stock)) { // а нет такого товара
                    $this->error404();
                    return;
                } elseif ($stock < $charge) { // попытка списать больше, чем в наличии
                    $this->response = $this->response->withError([
                        'wrong_parameter' => "stock_charge must be greater than stock", 
                        'stock_charge' => $charge,
                        'stock' => $stock,
                    ], 412);
                    return;
                }
                // иначе это просто взаимная блокировка, ждём и пробуем повторить
                usleep(300 * ($this->attempts - $attempt)); // 0.3c, 0.6c, 0.9c
            }
            if ($success) {
                $result = [
                    'success' => true,
                    'data' => [
                        'id'    => $productId,
                        'stock' => isset($stock) ? $stock : ProductModel::getStock($productId),
                    ]
                ];
                $this->response = $this->response->withArray($result, 200);
            } else {
                $this->response = $this->response->withError(['db_locked' => 'Try again later'], 503);
            }
        }        
    }
}