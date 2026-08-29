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
                <strong><?= htmlspecialchars($user->getName()) ?></strong>
            </div>
            <a href="/create-service">
                Cadastrar Serviço
            </a>
        </aside>

        <main class="content">
            <h1>DASHBOARD</h1>
            <section class="services">
                <div class="service-section">
                    <h2>Últimos Serviços</h2>
                    <ul>
                        <?php foreach ($recentServices as $recentService): ?>
                        <li>
                            <?= htmlspecialchars($recentService['id_service']) ?> -
                            <?= htmlspecialchars($recentService['description']) ?>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="service-section">
                    <h2>Serviços Pendentes</h2>
                    <ul>
                        <?php foreach ($pendingServices as $pendingService): ?>
                        <li>
                            <?= htmlspecialchars($pendingService['id_service']) ?> -
                            <?= htmlspecialchars($pendingService['description']) ?>
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
                            <th class="">ID</th>
                            <th>DESCRIÇÃO</th>
                            <th>VALOR</th>
                            <th>STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($services as $service): ?>
                        <tr>
                            <td>
                                <?= htmlspecialchars($service['id_service']) ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($service['description']) ?>
                            </td>
                            <td>
                                R$ <?= number_format($service['price'], 2, ',', '.') ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($service['finished_at'] === null) ? 'Pendente' : 'Finalizado' ?>
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