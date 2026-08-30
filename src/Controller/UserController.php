<?php

namespace src\Controller;

use src\Repository\UserRepository;
use src\Entity\User;

class UserController
{
    public function __construct(private UserRepository $userRepository)
    {
    }
    // Redireciona para a tela de cadastro de usuario
    public function index(): void
    {
        require_once __DIR__ . '/../../views/create_user.php';
    }

    // Cria um usuario
    public function createUser(): void
    {
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        if ($email === false) {
            header('Location: /login');
            return;
        }
        $password = filter_input(INPUT_POST, 'password');
        if ($password === false) {
            header('Location: /login'); 
            return;
        }

        $name = explode('@', $email)[0];
        $success = $this->userRepository->addUser(new User($name, $email, $password, true));
        if ($success === false) {
            header('Location: /login');
        } else {
            header('Location: /dashboard');
        }
    }
}