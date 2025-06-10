<?php

namespace models;

use core\Core;
use core\Model;

class Ticket extends Model
{
    protected static $tableName = 'tickets';

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

    public static function findById($id): ?self
    {
        $db = Core::get()->db;
        $row = $db->select(self::$tableName, '*', ['id' => $id])[0] ?? null;
        if ($row) {
            $ticket = new self();
            $ticket->load($row);
            return $ticket;
        }
        return null;
    }

    public static function insert(array $data): bool
    {
        return Core::get()->db->insert(self::$tableName, $data);
    }

    public static function update(int $id, array $data): bool
    {
        return Core::get()->db->update(self::$tableName, $data, ['id' => $id]);
    }

    public static function delete(int $id): bool
    {
        return Core::get()->db->delete(self::$tableName, ['id' => $id]);
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
