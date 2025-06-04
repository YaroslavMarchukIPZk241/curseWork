<?php

namespace core;

class Template
{
    protected $templateFilePath;
    protected $paramsArray;
    public Controller $controller;
    public function __construct($templateFilePath)
    {
        $this->templateFilePath = $templateFilePath;
        $this->paramsArray = [];
    }
    public function __set($name, $value)
    {
        Core::get()->template->setParam($name, $value);
    }
    public function setParam($paramName, $paramValue)
    {
        $this->paramsArray[$paramName] = $paramValue;
    }
    public function setParams($params)
    {
            if (!is_array($params)) {
        throw new \InvalidArgumentException('setParams expects an array, got ' . gettype($params));
    }

    foreach ($params as $key => $value)
        $this->setParam($key, $value);
    }
    public function setTemplateFilePath($path)
    {
        $this->templateFilePath = $path;
    }
    public function getHTML()
    {
        ob_start();
    $this->controller = \core\Core::get()->controllerObject;
    extract($this->paramsArray);

    $path = $this->templateFilePath;

    // Нормалізуємо слеші
    $normalizedPath = str_replace(['\\', '/'], DIRECTORY_SEPARATOR, $path);

    // Перевіряємо, чи шлях починається з 'views' (без дублювання)
    $startsWithViews = strpos($normalizedPath, 'views' . DIRECTORY_SEPARATOR) === 0;

    if (!$startsWithViews) {
        $path = 'views' . DIRECTORY_SEPARATOR . $path;
    }

    // Додаємо розширення, якщо немає
    if (pathinfo($path, PATHINFO_EXTENSION) === '') {
        $path .= '.php';
    }

    include($path);
    $str = ob_get_contents();
    ob_end_clean();
    return $str;
    }
    public function display()
    {
        echo $this->getHTML();
    }
}