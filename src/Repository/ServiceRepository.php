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

    // Seleciona os serviços do usuário finalizado
    public function userRecentService(User $user): array
    {
        $sql = "SELECT * FROM service WHERE user_id_user = ? ORDER BY id_service DESC LIMIT 5";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(1, $user->getId(), PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    // Seleciona os serviços pendentes do usuário
    public function pendingServices(User $user): array
    {
        $sql = "SELECT * FROM service WHERE user_id_user = ? AND finished_at IS NULL";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(1, $user->getId(), PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    // Seleciona todos os serviços
    public function allServices(array $filters = []): array
    {
        $sql = "SELECT service.*, user.name AS user_name FROM service INNER JOIN user
            ON user.id_user = service.user_id_user WHERE 1=1";
            
        $params = [];
        
        if (!empty($filters['start_date'])) {
            $sql .= " AND service.created_at >= :start_date";
            $params['start_date'] = $filters['start_date'] . ' 00:00:00';
        }

        if (!empty($filters['end_date'])) {
            $sql .= " AND service.finished_at < :end_date";
            $params['end_date'] = date(
                'Y-m-d',
                strtotime($filters['end_date'] . ' +1 day')
            ) . ' 00:00:00';
        }
        if (!empty($filters['service'])) {
            $sql .= " AND service.description = :service";
            $params['service'] = $filters['service'];
        }
        if (!empty($filters['status'])) {
            if ($filters['status'] === 'pending') {
                $sql .= " AND service.finished_at IS NULL";
            } elseif ($filters['status'] === 'finished') {
                $sql .= " AND service.finished_at IS NOT NULL";
            }
        }
        if (!empty($filters['user'])) {
            $sql .= " AND user.name LIKE :user";
            $params['user'] = "%".$filters['user']."%";
        }
        

        $sql .= " ORDER BY service.id_service DESC";

        $statement = $this->pdo->prepare($sql);
        $statement->execute($params);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    // Adiciona um serviço ao usuario 
    public function addService(User $user, Service $service): bool
    {
        $sql = "INSERT INTO service (user_id_user, description, price) VALUES (?, ?, ?)";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(1, $user->getId(), PDO::PARAM_INT);
        $statement->bindValue(2, $service->getDescription(), PDO::PARAM_STR);
        $statement->bindValue(3, $service->getPrice(), PDO::PARAM_STR);
        return $statement->execute();
    }

    // Atualiza um serviço 
    public function updateService(Service $service): bool
    {
        $sql = "UPDATE service SET description = ?, price = ? WHERE id_service = ?";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(1, $service->getDescription(), PDO::PARAM_STR);
        $statement->bindValue(2, $service->getPrice(), PDO::PARAM_STR);
        $statement->bindValue(3, $service->getId(), PDO::PARAM_INT);
        return $statement->execute();
    }

    // Deleta um serviço 
    public function deleteService(int $id): bool
    {
        $sql = "DELETE FROM service WHERE id_service = ?";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(1, $id, PDO::PARAM_INT);
        return $statement->execute();
    }

    // Seleciona um serviço pelo id
    public function getServiceById(int $id): ?Service
    {
        $sql = "SELECT * FROM service WHERE id_service = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(['id' => $id]);
        $serviceData = $statement->fetch(PDO::FETCH_ASSOC);

        if ($serviceData === false) {
            return null;
        }

        $service = new Service();
        $service->setId($serviceData['id_service']);
        $service->setDescription($serviceData['description']);
        $service->setPrice($serviceData['price']);
        $service->setUserId($serviceData['user_id_user']);

        return $service;
    }

    // Marca um serviço como finalizado
    public function finishService(int $id, string $date, float $commission): bool
    {
        $sql = "UPDATE service SET finished_at = ?, commission = ? WHERE id_service = ?";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(1, $date, PDO::PARAM_STR);
        $statement->bindValue(2, $commission, PDO::PARAM_STR);
        $statement->bindValue(3, $id, PDO::PARAM_INT);
        return $statement->execute();
    }

    // Calcula o total de serviços finalizados do usuário
    public function totalServices(User $user): float
    {
        $sql = "SELECT COALESCE(SUM(price), 0) FROM service WHERE finished_at IS NOT NULL AND user_id_user = ?";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(1, $user->getId(), PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return (float) $result['COALESCE(SUM(price), 0)'];
    }

}