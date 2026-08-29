<?php

// Dados de exemplo
$servicos = [
    [
        'id' => '4585874',
        'descricao' => 'Troca de Tela LED',
        'valor' => 425.00,
        'status' => 'PENDENTE'
    ],
    [
        'id' => '9945258',
        'descricao' => 'Limpeza de Computador',
        'valor' => 100.00,
        'status' => 'FINALIZADO'
    ]
];

// Dados exibidos nas listas
$ultimosServicos = [
    '127569 - Troca de Tela de Notebook',
    '986759 - Conserto de carregador',
    '567867 - Troca de pasta térmica'
];

$servicosPendentes = [
    '4562345 - Instalação de Office 2016',
    '4585458 - Reparo de Sistema Operacional',
    '458745 - Troca de Memória'
];

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
    <div class="container-dashboard">
        <aside class="sidebar">
            <div class="usuario">
                Logado como:
                <strong>José Silva</strong>
            </div>
            <div class="menu">
                Cadastrar Serviço
            </div>
        </aside>

        <main class="content">
            <h1>DASHBOARD</h1>
            <section class="services">
                <div class="service-section">
                    <h2>Últimos Serviços</h2>
                    <ul>
                        <?php foreach ($ultimosServicos as $servico): ?>
                        <li>
                            <?= htmlspecialchars($servico) ?>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="service-section">
                    <h2>Serviços Pendentes</h2>
                    <ul>
                        <?php foreach ($servicosPendentes as $servico): ?>
                        <li>
                            <?= htmlspecialchars($servico) ?>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </section>
            <form class="filters" method="GET">
                <input type="text" name="nome" placeholder="Nome">
                <input type="date" name="data_inicio" value="2024-08-15">
                <input type="date" name="data_fim" value="2024-08-26">
                <button type="submit">
                    Filtrar
                </button>
            </form>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>DESCRIÇÃO</th>
                            <th>VALOR</th>
                            <th>STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($servicos as $servico): ?>
                        <tr>
                            <td>
                                <?= htmlspecialchars($servico['id']) ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($servico['descricao']) ?>
                            </td>
                            <td>
                                R$ <?= number_format($servico['valor'], 2, ',', '.') ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($servico['status']) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>

</html>