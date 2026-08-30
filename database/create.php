<?php

require_once __DIR__ . '/../config/database.php';
// Arquivo destinado para inserir dados inciais no banco
$users = [
    [
        'name' => 'Jose Silva',
        'email' => 'jose@email.com',
        'password' => 'jose123456',
        'services' => [
            [
                'description' => 'Troca de tela do notebook',
                'price' => 450,
                'finished_at' => null
            ],
            [
                'description' => 'Conserto do carregador',
                'price' => 100,
                'commission' => 5,
                'finished_at' => '2026-09-01 15:30:00'
            ],
            [
                'description' => 'Troca da pasta térmica',
                'price' => 100,
                'commission' => 5,
                'finished_at' => '2026-09-01 15:30:00'
            ],
            [
                'description' => 'Instalação do Office 2016',
                'price' => 150,
                'finished_at' => null
            ],
            [
                'description' => 'Troca de Memória',
                'price' => 50.00,
                'finished_at' => null
            ],
            [
                'description' => 'Troca da Tela LED',
                'price' => 425.00,
                'finished_at' => null
            ],
            [
                'description' => 'Limpeza de notebook',
                'price' => 100.00,
                'finished_at' => '2026-09-01 15:30:00'
            ]
        ]
    ],
];

$sqlUser = '
    INSERT INTO user (name, email, password)
    VALUES (:name, :email, :password)
';

$sqlService = '
    INSERT INTO service (
        description,
        price,
        commission,
        finished_at,
        user_id_user
    )
    VALUES (
        :description,
        :price,
        :commission,
        :finished_at,
        :user_id_user
    )
';

try {

    $pdo->beginTransaction();
    $stmtUser = $pdo->prepare($sqlUser);
    $stmtService = $pdo->prepare($sqlService);

    foreach ($users as $user) {
        $hashedPassword = password_hash(
            $user['password'],
            PASSWORD_ARGON2ID
        );
        
        $stmtUser->execute([
            'name' => $user['name'],
            'email' => $user['email'],
            'password' => $hashedPassword
        ]);
        
        $userId = $pdo->lastInsertId();

        echo "Usuário criado: {$user['name']} - {$user['email']}\n";


        foreach ($user['services'] as $service) {

            $stmtService->execute([
                'description' => $service['description'],
                'price' => $service['price'],
                'commission' => $service['commission'] ?? null,
                'finished_at' => $service['finished_at'],
                'user_id_user' => $userId
            ]);

            echo "  Serviço criado: {$service['description']}\n";
        }
    }

    $pdo->commit();

    echo "\nTodos os usuários e serviços foram criados com sucesso!\n";

} catch (PDOException $e) {

    $pdo->rollBack();

    echo "Erro ao criar usuários e serviços: " . $e->getMessage();
}