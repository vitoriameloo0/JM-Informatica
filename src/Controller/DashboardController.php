<?php

namespace src\Controller;

class DashboardController
{
    public function index(): void
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /');
            exit;
        }

        require __DIR__ . '/../../views/dashboard.php';
    }
}