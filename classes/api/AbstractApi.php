<?php
declare(strict_types = 1);
use PhpRestfulApiResponse\Response; 

/**
 * Абстрактный класс контроллера API
 */
abstract class AbstractApi
{
    /**
     * Экземпляр объекта ответа
     *
     * @var Responce
     */
    protected Response $response;

    /**
     * Был ли сгенерирован вывод заголовков/тела ответа
     *
     * @var boolean
     */
    protected bool $rendered;

    /**
     * Конструктор
     * 
     * @param ProductModelInterface модель для работы с товарами
     */
    function __construct(array $path = [], array $data = []) 
    {
        $this->response = new Response();
        $this->rendered = false;
    }

    /**
     * Главный метод контроллера, в котором происходит формирование нужного ответа
     * @param array $path - Массив match из разбора урла регуляркой
     * @param array $data - Данные из тела запроса
     *
     * @return void
     */
    abstract function run(array $path = [], array $data = []); 

    /**
     * Генератор ответа 404 (не найдено)
     *
     * @return void
     */
    function error404() 
    {
        $this->response = $this->response->errorNotFound();
    }

    /**
     * Генератор ответа 400 (неверный запрос)
     * 
     *
     * @param array $message - Сообщение ответа
     * @return void
     */
    function error400(array $message)
    {
        $this->response = $this->response->errorWrongArgs($message);
    }

    /**
     * Формирование вывода
     *
     * @return void
     */
    function render() {
        header('HTTP/1.0 ' . $this->response->getStatusCode() . ' ' . $this->response->getReasonPhrase());
        header('Content-Type: application/json');
        echo $this->response->getBody();
        $this->rendered = true;
    }

    /**
     * Деструктор, делающий вызов render необязательным
     */
    function __destruct()
    {
        if (!$this->rendered) {
            $this->render();
        }
    }
}