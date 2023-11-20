<?php
/**
 * 404
 */
class ApiNotFound extends AbstractApi
{
    function processing() {
        $this->response = $this->response->errorNotFound();
    }
}