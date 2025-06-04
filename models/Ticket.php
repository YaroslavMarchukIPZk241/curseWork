<?php

namespace models;

use core\Core;
use core\Model;

class Ticket  extends Model
{
    protected static  $tableName = 'tickets';

    public int $id;
    public string $title;
    public float $price;
    public string $description;
    public string $available_at;

    public static function findAll(): array
    {
        $db = Core::get()->db;
        $rows = $db->select(self::$tableName);
        return array_map(function($row) {
            $ticket = new self();
            $ticket->load($row);
            return $ticket;
        }, $rows);
    }

    public static function findById($id) {
    $db = Core::get()->db;
    $row = $db->select(self::$tableName, '*', ['id' => $id])[0] ?? null;
    if ($row) {
        $ticket = new self();
        $ticket->load($row);
        return $ticket;
    }
    return null;
}
public function load(array $data): void
{
    foreach ($data as $key => $value) {
        if (property_exists($this, $key)) {
            $this->$key = $value;
        }
    }
}
}