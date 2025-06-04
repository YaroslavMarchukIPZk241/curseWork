<?php
declare(strict_types=1);
//session_start();

require_once 'vendor/autoload.php'; // або інший автозавантажувач

use core\Core;

Core::get()->init();

$route = $_GET['route'] ?? 'home/index';
$segments = explode('/', trim($route, '/'));

$controllerName = ucfirst($segments[0]) . 'Controller'; // Наприклад: ExhibitsController
$actionName = 'action' . ucfirst($segments[1] ?? 'index'); // Наприклад: actionView
$params = array_slice($segments, 2); // Наприклад: [5]

$controllerClass = 'controllers\\' . $controllerName;

if (class_exists($controllerClass)) {
    $controller = new $controllerClass();

    if (method_exists($controller, $actionName)) {
        echo $controller->$actionName($params);
        exit;
    }
}

http_response_code(404);
echo "Сторінка не знайдена";