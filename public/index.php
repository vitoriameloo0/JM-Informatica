<?php

use src\Controller\LoginController;
use src\Controller\DashboardController;
use src\Controller\UserController;
use src\Controller\ServiceController;
use src\Repository\UserRepository;
use src\Repository\ServiceRepository;
use src\Service\MailService;

require_once __DIR__ . '/../autoload.php';
require_once __DIR__ . '/../config/database.php';

$routes = require_once __DIR__ . '/../config/routes.php';

// Inicia uma sessão para verificar se o usuario esta logado
session_start();

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); 

$isLoginRoute = $uri === '/login';

// Verifica se o usuario esta logado, se não estiver é redirecionado para o login
if (!array_key_exists('user_id', $_SESSION) && !$isLoginRoute) {
    header('Location: /login');
    return;
}

if(!isset($routes[$httpMethod][$uri])) {
    http_response_code(404);
    echo "Página não encontrada";
    exit;
}


[$controller, $action] = $routes[$httpMethod][$uri];
$userRepository = new UserRepository($pdo); 
$serviceRepository = new ServiceRepository($pdo); 
$mailService = new MailService();

// Instancia os controllers com as dependencias que serao usadas no projeto 
$controller = match ($controller) {
    'LoginController' => new LoginController($userRepository),
    'DashboardController' => new DashboardController($userRepository, $serviceRepository),
    'UserController' => new UserController($userRepository),
    'ServiceController' => new ServiceController($serviceRepository, $userRepository, $mailService),
    default => null,
};

// Executa a ação
$controller->$action();