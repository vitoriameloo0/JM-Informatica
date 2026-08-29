<?php

use src\Controller\LoginController;
use src\Controller\DashboardController;
use src\Controller\UserController;
use src\Controller\ServiceController;
use src\Repository\UserRepository;
use src\Repository\ServiceRepository;

require_once __DIR__ . '/../autoload.php';
require_once __DIR__ . '/../config/database.php';

$routes = require_once __DIR__ . '/../config/routes.php';

session_start();

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); 

$isLoginRoute = $uri === '/login';

if (!array_key_exists('user_id', $_SESSION) && !$isLoginRoute) {
    header('Location: /login');
    return;
}

if(!isset($routes[$httpMethod][$uri])) {
    http_response_code(404);
    echo "Página não encontrada";
    return;
}


[$controller, $action] = $routes[$httpMethod][$uri];
$userRepository = new UserRepository($pdo); 
$serviceRepository = new ServiceRepository($pdo); 

$controller = match ($controller) {
    'LoginController' => new LoginController($userRepository),
    'DashboardController' => new DashboardController($userRepository, $serviceRepository),
    'UserController' => new UserController($userRepository),
    'ServiceController' => new ServiceController($serviceRepository, $userRepository),
    default => null,
};

if ($controller === null) {
    http_response_code(500);
    echo 'Controller não encontrado.';
    exit;
}

// Verifica se o método existe no controller
if (!method_exists($controller, $action)) {
    http_response_code(500);
    echo 'Ação não encontrada no controller.';
    exit;
}

// Executa a ação
$controller->$action();