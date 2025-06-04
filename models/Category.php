<?php
namespace models;

use core\Model;
use core\Core;
/**
 * @property int $id
 * @property string $name
 */

class Category extends Model
{
     protected static $tableName = 'categories';

   public function save()
{
    $id = $this->__get('id');
    $name = $this->__get('name');

    if (!empty($id)) {
        return Core::get()->db->update(
            static::$tableName,
            ['name' => $name],
            ['id' => $id]
        );
    } else {
        return Core::get()->db->insert(
            static::$tableName,
            ['name' => $name]
        );
    }
}

 public static function findById($id): ?self
{
    $data = Core::get()->db->select(static::$tableName, '*', ['id' => $id]);

    if (!empty($data)) {
        $category = new self();
        $category->id = $data[0]['id'];
        $category->name = $data[0]['name'];
        return $category;
    }

    return null;
}

    public static function deleteById($id)
    {
        return Core::get()->db->delete(
            static::$tableName,
            ['id' => $id]
        );
    }
    public static function findAll(): array
{
    $data = Core::get()->db->select(static::$tableName);
    $result = [];
    foreach ($data as $row) {
        $item = new self();
        $item->id = $row['id'];
        $item->name = $row['name'];
        $result[] = $item;
    }
    return $result;
}
}
?>