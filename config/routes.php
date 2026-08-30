<?php

$routes = [
    'GET' => [
        '/login' => ['LoginController', 'index'],
        '/dashboard' => ['DashboardController', 'index'],
        '/create-user' => ['UserController', 'index'],
        '/create-service' => ['ServiceController', 'index'],
    ],

    'POST' => [
        '/login' => ['LoginController', 'login'],
        '/create-user' => ['UserController', 'createUser'],
        '/create-service' => ['ServiceController', 'createService'],
        '/edit-service' => ['ServiceController', 'editService'],
        '/update-service' => ['ServiceController', 'updateService'],
        '/delete-service' => ['ServiceController', 'deleteService'],
        '/finish-service' => ['ServiceController', 'finishService'],
    ]
];
return $routes;