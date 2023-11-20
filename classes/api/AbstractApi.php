<?php
use PhpRestfulApiResponse\Response; 

abstract class AbstractApi
{
    protected $path;
    protected $data;
    protected $response;

    function __construct(array $path = [], array $data = []) 
    {
        $this->path = $path;
        $this->data = $data;
        $this->response = new Response();
    }

    abstract function processing(); 

    function render() {
        header('HTTP/1.0 ' . $this->response->getStatusCode() . ' ' . $this->response->getReasonPhrase());
        header('Content-Type: application/json');
        echo $this->response->getBody();
    }
}