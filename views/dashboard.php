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
                <strong><?= htmlspecialchars(is_object($user) ? $user->getName() : $user) ?></strong>
            </div>
            <div class="usuario">
                Data:
                <strong><?= date('d/m/Y') ?></strong>
            </div>
            <a href="/create-service">
                Cadastrar Serviço
            </a>
        </aside>

        <main class="content">
            <h1>DASHBOARD</h1>

            <?php if (isset($_SESSION['success'])): ?>
            <div class="success-message">
                <?= htmlspecialchars($_SESSION['success']) ?>
            </div>

            <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
            <div class="error-message">
                <?= htmlspecialchars($_SESSION['error']) ?>
            </div>

            <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

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
            <div>
                <strong>Valor total dos serviços de
                    <?= htmlspecialchars(is_object($user) ? $user->getName() : $user)  ?>:</strong> R$
                <?= number_format($totalServices, 2, ',', '.') ?>
            </div>

            <br>

            <form class="filters" method="GET" action="/dashboard">
                <input type="text" name="user" placeholder="Nome do usuário"
                    value="<?= htmlspecialchars($_GET['user'] ?? '') ?>">

                <input type="text" name="service" placeholder="Nome do serviço"
                    value="<?= htmlspecialchars($_GET['description'] ?? '') ?>">

                <input type="date" name="start_date" value="<?= htmlspecialchars($_GET['start_date'] ?? '') ?>">

                <input type="date" name="end_date" value="<?= htmlspecialchars($_GET['end_date'] ?? '') ?>">

                <select name="status">
                    <option value="">Todos os status</option>
                    <option value="pending" <?= ($_GET['status'] ?? '') === 'pending' ? 'selected' : '' ?>>
                        Pendente
                    </option>

                    <option value="finished" <?= ($_GET['status'] ?? '') === 'finished' ? 'selected' : '' ?>>
                        Finalizado
                    </option>
                </select>
                <button type="submit">
                    Filtrar
                </button>
            </form>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>USER</th>
                            <th>DESCRIÇÃO</th>
                            <th>VALOR</th>
                            <th>STATUS</th>
                            <th>AÇÕES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($services as $service): ?>
                        <tr>
                            <td>
                                <?= htmlspecialchars($service['id_service']) ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($service['user_name']) ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($service['description']) ?>
                            </td>
                            <td>
                                R$ <?= number_format($service['price'], 2, ',', '.') ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($service['finished_at'] === null ? 'Pendente' : 'Finalizado') ?>
                            </td>
                            <td class="actions">
                                <form action="/edit-service" method="POST">
                                    <input type="hidden" name="id_service"
                                        value="<?= htmlspecialchars($service['id_service']) ?>">
                                    <button type="submit">
                                        Editar
                                    </button>
                                </form>
                                <form action="/delete-service" method="POST">
                                    <input type="hidden" name="id_service"
                                        value="<?= htmlspecialchars($service['id_service']) ?>">

                                    <button type="submit">
                                        Excluir
                                    </button>
                                </form>
                                <form action="/finish-service" method="POST">
                                    <input type="hidden" name="id_service"
                                        value="<?= htmlspecialchars($service['id_service']) ?>">

                                    <button type="submit">
                                        Finalizar
                                    </button>
                                </form>
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