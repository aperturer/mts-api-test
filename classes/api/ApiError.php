<?php
/**
 * Апи для отображаения ошибок. По дефолту - рендеринг 404
 */
class ApiError extends AbstractApi
{
    function run() {
        $this->error404();    
    }
}