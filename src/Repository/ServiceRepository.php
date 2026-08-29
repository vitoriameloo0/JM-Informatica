<?php

namespace src\Repository;

use PDO;
use src\Entity\User;
use src\Entity\Service;

class ServiceRepository
{

    public function __construct(private PDO $pdo)
    {
    }

    // Seleciona os ultimos 5 serviços do usuário finalizado
    public function userRecentService(User $user): array
    {
        $sql = "SELECT * FROM service WHERE user_id_user = :user_id ORDER BY id_service DESC LIMIT 5";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(['user_id' => $user->getId()]);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    // Seleciona os serviços pendentes do usuário
    public function pendingServices(User $user): array
    {
        $sql = "SELECT * FROM service WHERE user_id_user = :user_id AND finished_at IS NULL";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(['user_id' => $user->getId()]);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    // Seleciona todos os serviços do usuário
    public function allServices(User $user): array
    {
        $sql = "SELECT * FROM service WHERE user_id_user = :user_id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(['user_id' => $user->getId()]);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    // Adiciona um serviço ao usuario 
    public function addService(User $user, Service $service): bool
    {
        $sql = "INSERT INTO service (user_id_user, description, price) VALUES (?, ?, ?)";
        $statement = $this->pdo->prepare($sql);
        return $statement->execute([
            $user->getId(),
            $service->getDescription(),
            $service->getPrice()
        ]);
    }

}