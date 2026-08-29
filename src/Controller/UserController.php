<?php

namespace src\Controller;

use src\Repository\UserRepository;
use src\Entity\User;

class UserController
{
    public function __construct(private UserRepository $userRepository)
    {
    }
    public function index(): void
    {
        require_once __DIR__ . '/../../views/create_user.php';
    }

    public function createUser(): void
    {
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        if ($email === false) {
            header('Location: /');
            return;
        }
        $password = filter_input(INPUT_POST, 'password');
        if ($password === false) {
            header('Location: /');
            return;
        }

        $name = explode('@', $email)[0];
        $success = $this->userRepository->addUser(new User($name, $email, $password, true));
        if ($success === false) {
            header('Location: /');
        } else {
            header('Location: /dashboard');
        }
    }
}