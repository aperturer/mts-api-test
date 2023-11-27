<?php

declare(strict_types=1);

/**
 * Интерфейс входящего запроса, или его эмуляции
 */
interface RequestInterface
{
    /**
     * Метод (тип) запроса
     *
     * @return string
     */
    public function getMethod(): string;

    /**
     * Данные запроса. Если не распарсились в json то null
     *
     * @return array|null
     */
    public function getData(): ?array;

    /**
     * Тело запроса, если есть
     *
     * @return string|null
     */
    public function getBody(): ?string;

    /**
     * Путь из урла запроса
     *
     * @return string
     */
    public function getPath(): string;
}
