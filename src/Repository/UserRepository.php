<?php

namespace src\Repository;

use PDO;
use src\Entity\User;

class UserRepository
{
    public function __construct(private PDO $pdo)
    {
    }
    
    // Retorna o usuario a partir do seu id
    public function getUserById(int $id): ?User
    {
        $sql = "SELECT * FROM user WHERE id_user = ?";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(1, $id);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $user = new User();
            $user->setId(intval($result['id_user']));
            $user->setName($result['name']);
            $user->setEmail($result['email']);
            $user->setPassword($result['password']);
            $user->setAtivo($result['ativo']);

            return $user;
        }

        return null;
    }

    // Retornar o usuario a partir do seu email
    public function getUserByEmail(string $email): ?User
    {
        $sql = "SELECT * FROM user WHERE email = ?";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(1, $email);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $user = new User();
            $user->setId(intval($result['id_user']));
            $user->setName($result['name']);
            $user->setEmail($result['email']);
            $user->setPassword($result['password']);
            $user->setAtivo($result['ativo']);

            return $user;
        }

        return null;
    }
    
    // Adiciona um novo usuario
    public function addUser(User $user): bool
    {
        $passwordHash = password_hash($user->getPassword(), PASSWORD_ARGON2I);
        
        $sql = "INSERT INTO user (name, email, password, ativo) VALUES (?, ?, ?, ?)";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(1, $user->getName());
        $statement->bindValue(2, $user->getEmail());
        $statement->bindValue(3, $passwordHash);
        $statement->bindValue(4, $user->getAtivo());
        
        $result = $statement->execute();
        $id = $this->pdo->lastInsertId();
        $user->setId(intval($id));

        return $result;
    }

}