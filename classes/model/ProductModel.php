<?php
declare(strict_types = 1);
/**
 * Модель для работы с таблицей товаров
 */
class ProductModel implements ProductModelInterface
{
    const TABLE = 'products';

    /**
     * Стоки по товару
     *
     * @param integer $id
     * @return integer|null
     */
    function getStock(int $id): ?int
    {
        $sql = 'SELECT stock FROM ' . self::TABLE . ' WHERE id = :id';
        $stmt = DBConnect::get()->prepare($sql);
        $stmt->bindParam(':id',  $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return is_array($result) ? $result['stock'] : null;
    }

    /**
     * Списать заданное количество со стоков товара
     *
     * @param integer $id        - ProdID
     * @param integer $substract - Количество единиц товара, которое пытаемся списать
     * @return boolean
     */
    function stockReduce(int $id, int $substract): bool
    {
        $tbl = self::TABLE;
        $sql = <<<SQL
            WITH chargeable AS (
                SELECT id 
                FROM $tbl
                WHERE id = :id
                AND stock >= :sub -- нельзя допустить отрицательных стоков
                LIMIT 1
                FOR UPDATE SKIP LOCKED  -- и нельзя допустить одновременного редактирования двумя клиентами
            ) 
            UPDATE $tbl
            SET stock = stock - :sub
            FROM chargeable
            WHERE $tbl.id = chargeable.id
            RETURNING $tbl.id
        SQL; // подход select for update
        $stmt = DBConnect::get()->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':sub', $substract, PDO::PARAM_INT);
        $stmt->execute();
        return (bool) $stmt->fetchColumn(); 
    }

    /**
     * Список товаров, чисто самодеятельность
     *
     * @param integer $limit
     * @param integer $offset
     * @return Generator
     */
    function getProductsGen(int $limit = 1000, int $offset = 0): Generator
    {
        $sql = 'SELECT * FROM ' . self::TABLE . ' ORDER BY id LIMIT :lmt OFFSET :oft';
        $stmt = DBConnect::get()->prepare($sql);
        $stmt->bindParam(':lmt', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':oft', $offset, PDO::PARAM_INT);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $key = current($row);
            yield $key => $row;
        }
    }   

}