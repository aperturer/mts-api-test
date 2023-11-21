<?php
/**
 * Входящий запрос
 */
class Request
{
    // Типы запроса
    const POST   = 'POST';   // Create
    const GET    = 'GET';    // Read
    const PUT    = 'PUT';    // Update/Replace
    const PATCH  = 'PATCH';  // Update/Modify
    const DELETE = 'DELETE'; // Delete

    /**
     * Метод (тип) запроса
     *
     * @var string
     */
    public $method;

    /**
     * Данные запроса. Если не распарсились в json то null
     *
     * @var array|null
     */
    public $requestData;

    /**
     * Тело запроса, если есть
     *
     * @var string|false|null
     */
    public $body;

    /** 
     * Путь из урла запроса
     */
    public $path;

    function __construct()
    {
        $this->path = $_REQUEST['path'] ?? '';
        $this->method = mb_strtoupper($_SERVER['REQUEST_METHOD'] ?? 'NONE');
        
        switch($this->method){
            // GET или POST: данные возвращаем как есть
            case self::GET:
                $this->requestData = $_GET;
                break;
            case self::POST:
                $this->requestData = $_POST;
                break;
            // PUT, PATCH или DELETE: берём json из тела запроса    
            case self::PUT:
            case self::PATCH:
            case self::DELETE:
                if ($this->body = file_get_contents('php://input')) {
                    $data = json_decode($this->body, true);
                    $this->requestData = json_last_error() === JSON_ERROR_NONE ? $data : null;
                } else {
                    $this->requestData = '';
                }
                break;
            default:
                throw new Exception("Incorrect request method: '{$this->method}'");
        }
    }
}