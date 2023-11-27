<?php

declare(strict_types=1);

/**
 * Интерфейс модели товаров, или её эмуляции
 */
interface ProductModelInterface
{
  /**
   * Стоки по товару
   *
   * @param integer $id
   * @return integer|null
   */
  public function getStock(int $id): ?int;

  /**
   * Списать заданное количество со стоков товара
   *
   * @param integer $id        - ProdID
   * @param integer $substract - Количество единиц товара, которое пытаемся списать
   * @return boolean
   */
  public function stockReduce(int $id, int $substract): bool;

  /**
   * Генератор списка товаров
   *
   * @param integer $limit
   * @param integer $offset
   * @return Generator
   */
  public function getProductsGen(int $limit = 1000, int $offset = 0): Generator;
}
