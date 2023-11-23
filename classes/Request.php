<?php
declare(strict_types = 1);
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

    private $method;
    private $requestData;
    private $body;
    private $path;

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
                if ($this->body = file_get_contents('php://input') ?: null) {
                    $data = json_decode($this->body, true);
                    if (json_last_error() === JSON_ERROR_NONE) {
                        $this->requestData = is_array($data) ? $data : [$data];
                    } else {
                        $this->requestData = null;
                    }
                } else {
                    $this->requestData = [];
                }
                break;
            default:
                throw new Exception("Incorrect request method: '{$this->method}'");
        }
    }

    /**
     * Метод (тип) запроса
     *
     * @return string
     */
    function getMethod(): string
    {
        return $this->method;
    }

    /**
     * Данные запроса. Если не распарсились в json то null
     *
     * @return array|null
     */
    function getData(): ?array
    {
        return $this->requestData;
    }

    /**
     * Тело запроса, если есть
     *
     * @return string|null
     */
    function getBody(): ?string
    {
        return $this->body;
    }

    /**
     * Путь из урла запроса
     *
     * @return string
     */
    function getPath(): string
    {
        return $this->path;
    }
}