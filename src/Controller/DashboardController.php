<?php

namespace src\Controller;

use src\Repository\UserRepository;
use src\Repository\ServiceRepository; 
use src\Entity\User;  

class DashboardController
{
    public function __construct(private UserRepository $userRepository, private ServiceRepository $serviceRepository)
    {
    }
    
    // Funcao para exibir o dashboard
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
        
        $filters = [
            'start_date' => $_GET['start_date'] ?? null,
            'end_date' => $_GET['end_date'] ?? null,
            'service' => $_GET['service'] ?? null,
            'status' => $_GET['status'] ?? null,
            'user' => $_GET['user'] ?? null,
        ];

        $services = $this->serviceRepository->allServices($filters);
        $recentServices = $this->serviceRepository->userRecentService($user);
        $pendingServices = $this->serviceRepository->pendingServices($user);
        $totalServices = $this->serviceRepository->totalServices($user);

        require __DIR__ . '/../../views/dashboard.php';
    }
}