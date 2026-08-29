<?php

require_once __DIR__ . '/../config/database.php';

$users = [
    [
        'name' => 'Maria',
        'email' => 'maria@email.com',
        'password' => 'maria123456',
        'services' => [
            [
                'description' => 'Manutenção de computador',
                'price' => 150.000,
                'commission' => 30.000,
                'finished_at' => null
            ],
            [
                'description' => 'Instalação de software',
                'price' => 80.000,
                'commission' => 15.000,
                'finished_at' => '2026-08-20 15:30:00'
            ]
        ]
    ],

    [
        'name' => 'Joao',
        'email' => 'joao@email.com',
        'password' => 'joao123',
        'services' => [
            [
                'description' => 'Formatação de computador',
                'price' => 120.000,
                'commission' => 25.000,
                'finished_at' => '2026-08-21 10:00:00'
            ],
            [
                'description' => 'Limpeza interna',
                'price' => 100.000,
                'commission' => 20.000,
                'finished_at' => null
            ]
        ]
    ],

    [
        'name' => 'Ana',
        'email' => 'ana@email.com',
        'password' => 'ana123',
        'services' => [
            [
                'description' => 'Troca de HD',
                'price' => 250.000,
                'commission' => 50.000,
                'finished_at' => '2026-08-22 14:00:00'
            ],
            [
                'description' => 'Instalação de impressora',
                'price' => 90.000,
                'commission' => 18.000,
                'finished_at' => null
            ]
        ]
    ],

    [
        'name' => 'Lucas',
        'email' => 'lucas@email.com',
        'password' => 'lucas123',
        'services' => [
            [
                'description' => 'Configuração de rede',
                'price' => 180.000,
                'commission' => 35.000,
                'finished_at' => '2026-08-23 09:30:00'
            ],
            [
                'description' => 'Manutenção de notebook',
                'price' => 200.000,
                'commission' => 40.000,
                'finished_at' => null
            ]
        ]
    ]
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

        // Pega o ID do usuário criado
        $userId = $pdo->lastInsertId();

        echo "Usuário criado: {$user['name']} - {$user['email']}\n";

        // Cria os serviços desse usuário
        foreach ($user['services'] as $service) {

            $stmtService->execute([
                'description' => $service['description'],
                'price' => $service['price'],
                'commission' => $service['commission'],
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