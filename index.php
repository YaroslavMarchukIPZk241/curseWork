<?php

ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/php_error.log');
error_reporting(E_ALL);


ob_start();


register_shutdown_function(function () {
    $error = error_get_last();
    if ($error !== null && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        file_put_contents(__DIR__ . '/shutdown.log', print_r($error, true));
        if (ob_get_length()) {
            ob_end_clean();
        }

        http_response_code(500);
        include 'views/errors/500.php';
        exit;
    }
});

try {
    require_once 'autoload.php';

    $route = $_GET['route'] ?? null;

    $core = \core\Core::get();
    $core->run($route);
    $core->done();
    ob_end_flush();

} catch (Throwable $e) {
    error_log($e);

    if (ob_get_length()) {
        ob_end_clean();
    }

    $code = $e->getCode();
    if ($code === 403) {
        http_response_code(403);
        include 'views/errors/403.php';
    } elseif ($code === 404) {
        http_response_code(404);
        include 'views/errors/404.php';
    } else {
        http_response_code(500);
        include 'views/errors/500.php';
    }

    exit;
}
