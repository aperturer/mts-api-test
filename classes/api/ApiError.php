<?php

declare(strict_types=1);
/**
 * Апи для отображаения ошибок. По дефолту - рендеринг 404
 */
class ApiError extends AbstractApi
{
    public function run(array $path = [], array $data = [])
    {
        $this->error404();
    }
}
