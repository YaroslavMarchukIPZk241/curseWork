<?php

namespace models;

use core\Model;
use core\Core;

/**
 * @property int $id
 * @property string $name
 * @property string $image_path
 * @property string $DetailPeriod
 * @property string $TimePeriod
 * @property string $Section
 */
class Period extends Model
{
    public static $tableName = 'periods';

    // Повертаємо масив об'єктів Period
    public static function findAll()
    {
        $db = Core::get()->db;
        $rows = $db->select(self::$tableName);

        $objects = [];
        foreach ($rows as $row) {
            $obj = new self();
            foreach ($row as $field => $value) {
                $obj->$field = $value;
            }
            $objects[] = $obj;
        }
        return $objects;
    }

    public static function findById($id)
    {
        $db = Core::get()->db;
        $rows = $db->select(self::$tableName, '*', ['id' => $id]);
        if (empty($rows)) {
            return null;
        }
        $obj = new self();
        foreach ($rows[0] as $field => $value) {
            $obj->$field = $value;
        }
        return $obj;
    }

public function save()
{
    $id = $this->__get('id');  // Використати магічний геттер
    $name = $this->__get('name');
    $image_path = $this->__get('image_path');
    $DetailPeriod = $this->__get('DetailPeriod');
    $TimePeriod = $this->__get('TimePeriod');
    $Section = $this->__get('Section');

    $data = [
        'name' => $name,
        'image_path' => $image_path,
        'DetailPeriod' => $DetailPeriod,
        'TimePeriod' => $TimePeriod,
        'Section' => $Section,
    ];

    if (!empty($id)) {
        return Core::get()->db->update(self::$tableName, $data, ['id' => $id]);
    } else {
        $this->id = Core::get()->db->insert(self::$tableName, $data);
        return true;
    }
}

    public static function deleteById($id)
    {
        $db = Core::get()->db;
        return $db->delete(self::$tableName, ['id' => $id]);
    }

    // Залишаємо інші методи без змін
    public static function findPaginatedSortedByTime($limit, $offset)
    {
        $db = Core::get()->db;
        $sql = "SELECT * FROM " . static::$tableName . " 
                ORDER BY CAST(SUBSTRING_INDEX(TimePeriod, '-', 1) AS UNSIGNED) ASC 
                LIMIT :limit OFFSET :offset";

        $stmt = $db->pdo->prepare($sql);
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function countAll()
    {
        $db = Core::get()->db;
        $sql = "SELECT COUNT(*) as cnt FROM " . static::$tableName;
        $stmt = $db->pdo->query($sql);
        return (int) $stmt->fetchColumn();
    }
}