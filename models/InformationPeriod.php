<?php
 namespace models;

use core\Model;
use core\Core;

/**
 * @property int $id
 * @property string $name
 * @property string $link
 * @property int $Period_id
 * @property string $information
 */
class InformationPeriod extends Model
{
    public static $tableName = 'information_period';

    public static function findByPeriodId($periodId)
    {
        $db = Core::get()->db;
        $rows = $db->select(self::$tableName, '*', ['Period_id' => $periodId]);

        $objects = [];
        foreach ($rows as $row) {
            $obj = new self();
            foreach ($row as $key => $value) {
                $obj->$key = $value;
            }
            $objects[] = $obj;
        }

        return $objects;
    }
}
