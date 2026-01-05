<?php
/**
 * Entry Point Application
 */

session_start();

define('BASE_PATH', __DIR__);
define('BASE_URL', 'http://localhost/project_uas_web');

require_once BASE_PATH . '/config/database.php';

spl_autoload_register(function ($class) {
    $paths = [
        BASE_PATH . '/app/controllers/',
        BASE_PATH . '/app/models/',
    ];
    
    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

$url = isset($_GET['url']) ? $_GET['url'] : 'auth/login';
$url = rtrim($url, '/');
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = explode('/', $url);

$controllerName = !empty($url[0]) ? ucfirst($url[0]) . 'Controller' : 'AuthController';
$method = isset($url[1]) ? $url[1] : 'login';
$params = array_slice($url, 2);

$controllerFile = BASE_PATH . '/app/controllers/' . $controllerName . '.php';
if (!file_exists($controllerFile)) {
    $controllerName = 'AuthController';
    $method = 'login';
}

$controller = new $controllerName();

if (!method_exists($controller, $method)) {
    $method = 'index';
}

call_user_func_array([$controller, $method], $params);