<?php

namespace src\Controller;

use src\Entity\Service;
use src\Entity\User;
use src\Repository\ServiceRepository;
use src\Repository\UserRepository;

class ServiceController
{
    public function __construct(private ServiceRepository $serviceRepository, private UserRepository $userRepository)
    {
    }

    public function index(): void
    {
        require_once __DIR__ . '/../../views/create_service.php';
    }

    public function createService(): void
    {
        $description = filter_input(INPUT_POST, 'description');
        if ($description === false) {
            header('Location: /');
            return;
        }
        $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
        if ($price === false) {
            header('Location: /');
            return;
        }
        $user = $this->userRepository->getUserById($_SESSION['user_id']);
        
        $service = new Service();
        $service->setDescription($description);
        $service->setPrice($price);
        
        $success = $this->serviceRepository->addService($user, $service);
        if ($success === false) {
            header('Location: /');
        } else {
            header('Location: /dashboard');
        }
    }
}