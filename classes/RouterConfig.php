<?php
/**
 * Конфигурация пути роутера
 */
class RouterConfig {
    const POST   = 'POST';   // Create
    const GET    = 'GET';    // Read
    const PUT    = 'PUT';    // Update/Replace
    const PATCH  = 'PATCH';  // Update/Modify
    const DELETE = 'DELETE'; // Delete

    public $method;
    public $path;
    public $class;

    function __construct(string $method, string $path, string $class)
    {
        $methods = [self::POST, self::GET, self::PUT, self::PATCH, self::DELETE];
        if (!in_array($method, $methods)) {
            throw new Exception('incorrect method ' . $method);
        }
        if (!class_exists($class, true)) {
            throw new Exception('incorrect api class '.$class);
        }    
        $this->method = $method;
        $this->path = $path;
        $this->class = $class;
    }
}