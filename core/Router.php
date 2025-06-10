<?php

namespace core;

use core\Logger;

class Router
{
    protected $route;

    public function __construct($route)
    {
        $this->route = $route ?: 'home/index';
    }

    public function run()
    {
        ob_start();

        $paramsJson = '[]'; 

        try {
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

            $action = 'index';
            $controllerParts = [];

            if ($parts[0] === 'admin') {
                $user = $_SESSION['user'] ?? null;

                if (!$user || $user['role'] !== 'admin') {
                    Logger::log(
                        '403',
                        'Спроба несанкціонованого доступу до адмін-панелі',
                        $user['id'] ?? null,
                        $_SERVER['REQUEST_METHOD'] ?? 'UNKNOWN',
                        $_SERVER['REQUEST_URI'] ?? '',
                        json_encode($parts, JSON_UNESCAPED_UNICODE)
                    );
                    throw new \Exception("Access denied", 403);
                }

                $controllerParts = isset($parts[1]) ? ['admin', $parts[1]] : ['admin', 'home'];
                $action = $parts[2] ?? 'index';
                $params = array_slice($parts, 3);
            } else {
                $controllerParts = [$parts[0]];
                $action = $parts[1] ?? 'index';
                $params = array_slice($parts, 2);
            }

            $paramsJson = json_encode($params ?? [], JSON_UNESCAPED_UNICODE);
            $namespaceParts = array_map('ucfirst', $controllerParts);
            $controllerClass = implode('\\', $namespaceParts) . 'Controller';
            $fullClass = 'controllers\\' . $controllerClass;

            \core\Core::get()->moduleName = implode('/', $controllerParts);
            \core\Core::get()->actionName = $action;

            $method = 'action' . ucfirst($action);

            $userId = $_SESSION['user']['id'] ?? null;
            $httpMethod = $_SERVER['REQUEST_METHOD'] ?? 'UNKNOWN';
            $uri = $_SERVER['REQUEST_URI'] ?? '';

            if (class_exists($fullClass)) {
                $controllerObject = new $fullClass();
                Core::get()->controllerObject = $controllerObject;

                if (method_exists($controllerObject, $method)) {
            
                    Logger::log(
                        $action,
                        "Виклик: {$fullClass}->{$method}",
                        $userId,
                        $httpMethod,
                        $uri,
                        $paramsJson
                    );
                    return $controllerObject->$method($params);
                } else {
                    Logger::log(
                        '404',
                        "Метод {$method} не знайдено в {$fullClass}",
                        $userId,
                        $httpMethod,
                        $uri,
                        $paramsJson
                    );
                    $controllerObject->error(404);
                }
            } else {
                Logger::log(
                    '404',
                    "Контролер {$fullClass} не знайдено",
                    $userId,
                    $httpMethod,
                    $uri,
                    $paramsJson
                );
                (new \core\Controller())->error(404);
            }

        } catch (\Throwable $e) {
            ob_end_clean();
            $userId = $_SESSION['user']['id'] ?? null;
            $httpMethod = $_SERVER['REQUEST_METHOD'] ?? 'UNKNOWN';
            $uri = $_SERVER['REQUEST_URI'] ?? '';
            $paramsJson = $paramsJson ?? '[]';
            $code = $e->getCode() ?: 500;

            Logger::log(
                $code,
                "Виняток: {$e->getMessage()}, File: {$e->getFile()}, Line: {$e->getLine()}",
                $userId,
                $httpMethod,
                $uri,
                $paramsJson
            );

            (new \core\Controller())->error($code);
        }
    }

    public function done() {}

    public function error($code)
    {
        http_response_code($code);
        $errorPage = "views/errors/{$code}.php";
        if (file_exists($errorPage)) {
            include $errorPage;
        } else {
            echo "$code - Помилка";
        }
        exit;
    }
}
