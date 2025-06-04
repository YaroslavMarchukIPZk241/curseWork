<?php

namespace core;

class Config
{
   protected $params;
    protected static $instance;

    private function __construct()
{
    $directory = 'config';
    $config_files = scandir($directory);
    $Config = []; // Оголошуємо масив

    foreach($config_files as $config_file)
    {
        if(substr($config_file, -4) === '.php')
        {
            $path = $directory . '/' . $config_file;
            $configData = include($path);
            if (is_array($configData)) {
                $Config[] = $configData;
            }
        }
    }

    $this->params = [];
    foreach($Config as $config)
    {
        foreach($config as $key => $value)
            $this->params[$key] = $value;
    }
}


    public static function get()
    {
        if (empty(self::$instance))
            self::$instance = new self();
        return self::$instance;
    }

    public function __set($name, $value)
    {
        $this->params[$name] = $value;
    }

    public function __get($name)
    {
        return $this->params[$name];
    }

    public function getBaseUrl()
    {
        return $this->params['baseUrl'] ?? '';
    }
}