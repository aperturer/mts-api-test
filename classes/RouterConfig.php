<?php
declare(strict_types = 1);

/**
 * Конфигурация пути роутера
 */
class RouterConfig {
    public $method;
    public $path;
    public $class;

    function __construct(string $method, string $path, string $class)
    {
        $methods = [Request::POST, Request::GET, Request::PUT, Request::PATCH, Request::DELETE];
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