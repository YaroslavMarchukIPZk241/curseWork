<?php
namespace models;

use core\Model;
use core\Core;

class InformationPeriod extends Model
{
    public static $tableName = 'information_period';

    public static function findAll()
    {
        $db = Core::get()->db;
        $rows = $db->select('information_period'); 
        $items = [];
        foreach ($rows as $row) {
            $item = new self();
            $item->id = $row['id'];
            $item->name = $row['name'];
            $item->link = $row['link'];
            $item->information = $row['information'];
            $item->Period_id = $row['Period_id'];
            $items[] = $item;
        }
        return $items;
    }

    public static function findByPeriodId(int $periodId)
    {
        $db = Core::get()->db;
        $rows = $db->select('information_period', ['*'], ['Period_id' => $periodId]);
        $items = [];
        foreach ($rows as $row) {
            $item = new self();
            $item->id = $row['id'];
            $item->name = $row['name'];
            $item->link = $row['link'];
            $item->information = $row['information'];
            $item->Period_id = $row['Period_id'];
            $items[] = $item;
        }
        return $items;
    }
}