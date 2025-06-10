<?php

namespace core;

class Model
{
    protected $fieldsArray;
    protected static $primaryKey = 'id';
    protected static $tableName = '';

    public function __construct()
    {
        $this->fieldsArray = [];
    }
    public function __set($name, $value)
    {
        $this->fieldsArray[$name] = $value;
    }
    public function __get($name)
    {
        return $this->fieldsArray[$name];
    }
    public function save()
{
    $primaryKey = static::$primaryKey;

    $isInsert = false;

    if (!isset($this->{$primaryKey}) || empty($this->{$primaryKey})) {
        $isInsert = true;
    }

    if ($isInsert) {
        // insert
        Core::get()->db->insert(static::$tableName, $this->fieldsArray);
    } else {
        // update
        Core::get()->db->update(static::$tableName, $this->fieldsArray, [
            $primaryKey => $this->{$primaryKey}
        ]);
    }
}
public function __isset($name)
{
    return isset($this->fieldsArray[$name]);
}
    public static function deleteById($id)
    {
        Core::get()->db->delete(static::$tableName, [static::$primaryKey => $id]);
    } 
    public static function deleteByCondition($conditionAssocArray)
    {
        Core::get()->db->delete(static::$tableName, $conditionAssocArray);
    }
public static function findById($id)
{
    $arr = Core::get()->db->select(static::$tableName, '*', [static::$primaryKey => $id]);
    if(count($arr) > 0) {
        $object = new static();
        foreach ($arr[0] as $key => $value) {
            $object->$key = $value;
        }
        return $object;
    } else {
        return null;
    }
}

    public static function findByCondition($conditionAssocArray): ?array
{
    $arr = Core::get()->db->select(static::$tableName, '*', $conditionAssocArray);
    if (count($arr) > 0) {
        $objects = [];
        foreach ($arr as $row) {
            $object = new static();
            foreach ($row as $key => $value) {
                $object->$key = $value;
            }
            $objects[] = $object;
        }
        return $objects;
    } else {
        return null;
    }
}







}