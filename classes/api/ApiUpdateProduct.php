<?php
class ApiUpdateProduct extends AbstractApi
{
    function processing() {
        //$this->response = $this->response->errorNotFound();
        var_dump($_POST);
        var_dump($this->data);
        die();
        // почему-то не проходят ни post ни put запросы. Разбираюсь. Метод для списания смотрите в ProductModel
    }
}