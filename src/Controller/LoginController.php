<?php

namespace src\Controller;

use src\Repository\UserRepository;

class LoginController
{
    private UserRepository $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    
    // Funcao para exibir a tela de login
    public function index(): void
    {
        require_once __DIR__ . '/../../views/login.php';
    }
    
    // Funcao que faz o login 
    public function login() : void
    {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($email === '' || $password === '') {
            $error = 'Ops, Email ou Senha inválido';

            require __DIR__ . '/../../views/login.php';
            return;
        }

        $user = $this->userRepository->getUserByEmail($email);

        if ($user === null || !password_verify($password, $user->getPassword())) {
            $error = 'Ops, Email ou Senha inválido';

            require __DIR__ . '/../../views/login.php';
            return;
        }

        session_regenerate_id(true);
        
        $_SESSION['user_id'] = $user->getId();
        
        header('Location: /dashboard');
        exit;
    }

    // Funcao que faz o logout do usuario  
    public function logout(): void
    {
        session_unset();
        session_destroy();
        header('Location: /login');
        exit;
    }

}