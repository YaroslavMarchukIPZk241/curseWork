<?php

namespace core;

class Router
{
    protected $route;
    public function __construct ($route)
    {
        $this->route = $route ?: 'home/index';
    }
  public function run()
{
    $this->route = trim($this->route, "/ \t\n\r\0\x0B");
    $parts = explode('/', $this->route);

    if (strtolower($this->route) === 'index') {
        header('Location: /MuseumShowcase/home');
        exit;
    }

    if (empty($parts[0])) {
        $parts[0] = 'home';
        $parts[1] = 'index';
    }

    // За замовчуванням:
    $action = 'index';
    $controllerParts = [];

    // Якщо перший сегмент - admin, шукаємо контролер у папках
    if ($parts[0] === 'admin') {
        // Припустимо, контролер у папці admin, може бути і 2 рівні вкладення
        // Наприклад: admin/category/edit/2 => controller admin\CategoryController, action edit, params [2]

        // Візьмемо другий сегмент як контролер (category)
        if (isset($parts[1])) {
            $controllerParts = ['admin', $parts[1]];
        } else {
            // Якщо немає другого сегменту, то просто адмін домашня сторінка
            $controllerParts = ['admin', 'home'];
        }
        // Action — третій сегмент або index
        $action = $parts[2] ?? 'index';

        // Параметри — все, що після 3-го сегменту
        $params = array_slice($parts, 3);
    } else {
        // Звичайний режим: перший сегмент — контролер, другий — action
        $controllerParts = [$parts[0]];
        $action = $parts[1] ?? 'index';
        $params = array_slice($parts, 2);
    }

    // Формуємо ім’я контролера
    $namespaceParts = array_map('ucfirst', $controllerParts);
    $controllerClass = implode('\\', $namespaceParts) . 'Controller';

    $fullClass = 'controllers\\' . $controllerClass;

    \core\Core::get()->moduleName = implode('/', $controllerParts);
    \core\Core::get()->actionName = $action;

    $method = 'action' . ucfirst($action);

   if (class_exists($fullClass)) {
    $controllerObject = new $fullClass();
    Core::get()->controllerObject = $controllerObject;

    if (method_exists($controllerObject, $method)) {
        return $controllerObject->$method($params);
    } else {
        $this->Error(404); // Метод не знайдено
    }
} else {
    $this->Error(404); // Клас не знайдено
}
}
public function done()
{

}
public function Error($code)
{
    http_response_code($code);

    $errorPage = "views/errors/{$code}.php";

    if (file_exists($errorPage)) 
    {
        include $errorPage;
    } 
    else
    {
        echo "$code - Помилка";
    }

    exit;
}
}