<?php

namespace src\Controller;

use src\Entity\User;
use src\Repository\UserRepository;
use src\Repository\ServiceRepository;   

class DashboardController
{
    public function __construct(private UserRepository $userRepository, private ServiceRepository $serviceRepository)
    {
    }
    public function index(): void
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $user = $this->userRepository->getUserById($_SESSION['user_id']);
        
        if ($user === null) {
            session_destroy();
            header('Location: /login');
            exit;
        }

        $services = $this->serviceRepository->allServices($user);
        $recentServices = $this->serviceRepository->userRecentService($user);
        $pendingServices = $this->serviceRepository->pendingServices($user);

        require __DIR__ . '/../../views/dashboard.php';
    }
}