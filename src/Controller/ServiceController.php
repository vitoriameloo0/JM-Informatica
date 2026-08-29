<?php

namespace src\Controller;

class ServiceController
{
    public function index(): void
    {
        require_once __DIR__ . '/../../views/create_service.php';
    }
}