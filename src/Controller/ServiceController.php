<?php

namespace src\Controller;

use src\Entity\Service;
use src\Repository\ServiceRepository;
use src\Repository\UserRepository;
use src\Service\MailService;

class ServiceController
{
    public function __construct(private ServiceRepository $serviceRepository, private UserRepository $userRepository, private MailService $mailService)
    {
    }

    // Redireciona para a tela de cadastro de serviço
    public function index(): void
    {
        require_once __DIR__ . '/../../views/create_service.php';
    }

    // Cria um serviço
    public function createService(): void
    {
        $description = filter_input(INPUT_POST, 'description');
        if ($description === false || $description === null || trim($description) === '') {
            $_SESSION['error'] = 'Descrição do serviço é obrigatória.';
            header('Location: /create-service');
            return;
        }
        $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
        if ($price === false || $price === null) {
            $_SESSION['error'] = 'Preço do serviço é obrigatório.';
            header('Location: /create-service');
            return;
        }

        if (!is_numeric($price) || (float) $price <= 0) {
            $_SESSION['error'] = 'Informe um preço válido maior que zero.';
            header('Location: /create-service');
            exit;
        }

        $price = (float) $price;
        $user = $this->userRepository->getUserById($_SESSION['user_id']);
        
        $service = new Service();
        $service->setDescription($description);
        $service->setPrice($price);
        
        $success = $this->serviceRepository->addService($user, $service);
        if ($success === false) {
            $_SESSION['error'] = 'Erro ao cadastrar serviço.';
            header('Location: /create-service');
            exit;
        } else {
            $_SESSION['success'] = 'Serviço cadastrado com sucesso.';
            header('Location: /dashboard');
            exit;
        }
    }
    
    // Redireciona para a tela de edição do serviço
    public function editService(): void
    {
        $id = filter_input(INPUT_POST, 'id_service', FILTER_VALIDATE_INT);

        if ($id === false || $id === null) {
            header('Location: /dashboard');
            exit;
        }

        $service = $this->serviceRepository->getServiceById($id);

        if ($service === null) {
            header('Location: /dashboard');
            exit;
        }

        require_once __DIR__ . '/../../views/edit_service.php';
    }

    // Atualiza um serviço
    public function updateService(): void
    {
        $id = filter_input(INPUT_POST, 'id_service', FILTER_VALIDATE_INT);
        if ($id === false || $id === null) {
            header('Location: /dashboard');
            return;
        }

        $description = filter_input(INPUT_POST, 'description');
        $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
        
        if ($description === '' || $price === false) {
            $error = 'Descrição e preço são obrigatórios.';
            require_once __DIR__ . '/../../views/edit_service.php';
            return;
        }
        
        $service = $this->serviceRepository->getServiceById($id);
        $service->setDescription($description);
        $service->setPrice($price);
        $success = $this->serviceRepository->updateService($service);
        
        if ($success === false) {
            require_once __DIR__ . '/../../views/edit_service.php';
        } else {
            header('Location: /dashboard');
        }
    }

    // Deleta um serviço
    public function deleteService(): void
    {
        $id = filter_input(INPUT_POST, 'id_service', FILTER_VALIDATE_INT);
        if ($id === false || $id === null) {
            header('Location: /dashboard');
            return;
        }

        $success = $this->serviceRepository->deleteService($id);
        if ($success === false) {
            $_SESSION['error'] = 'Não foi possivel deletar';
            header('Location: /dashboard');
        } else {
            $_SESSION['error'] = 'Serviço deletado com sucesso';
            header('Location: /dashboard');
        }
    }

    // Finaliza um serviço
    public function finishService(): void
    {
        $id = filter_input(INPUT_POST, 'id_service', FILTER_VALIDATE_INT);
        if ($id === false || $id === null) {
            header('Location: /dashboard');
            return;
        }

        $service = $this->serviceRepository->getServiceById($id);
        if ($service === null) {
            header('Location: /dashboard');
            return;
        }
        
        // Calculo das comissoes 
        if($service->getPrice()<= 1000) {
            $service->setCommission($service->getPrice() * 0.05); 
        } else if($service->getPrice() > 1000 && $service->getPrice() <= 10000) {
            $service->setCommission($service->getPrice() * 0.10); 
        } else if($service->getPrice() > 10000){
            $service->setCommission($service->getPrice() * 0.20); 
        }

        $service->setFinish(date('Y-m-d H:i:s'));
        $success = $this->serviceRepository->finishService($service->getId(), $service->getFinish(), $service->getCommission());

        if ($success === false) {
            header('Location: /dashboard');
        } 
        
        $user = $this->userRepository->getUserById($service->getUserId());
        $emailSent = $this->mailService->sendMail($user->getEmail(), $user->getName(), $service->getDescription());

        if (!$emailSent) {
            $_SESSION['error'] = 'Serviço finalizado, mas não foi possível enviar o e-mail.';
        } else {
            $_SESSION['success'] = 'Serviço finalizado e e-mail enviado com sucesso.';
        }
        header('Location: /dashboard');
    }
}