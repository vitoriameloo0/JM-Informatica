<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Serviço</title>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
    <main class="container">
        <div class="box">
            <h1>Cadastrar Novo Serviço</h1>

            <?php if (isset($error)): ?>
            <div class="error-message">
                <?= htmlspecialchars($error) ?>
            </div>
            <?php endif; ?>

            <form action="/create_service" method="POST">
                <div class="form-group">
                    <label for="service_description">
                        Descrição
                    </label>
                    <input type="text" id="service_description" name="service_description"
                        placeholder="Descrição do Serviço"
                        value="<?= htmlspecialchars($_POST['service_description'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label for="service_price">
                        Preço
                    </label>
                    <input type="text" id="service_price" name="service_price" placeholder="Preço do Serviço"
                        value="<?= htmlspecialchars($_POST['service_price'] ?? '') ?>">
                </div>
                <div class="actions">
                    <button type="submit" class="login">
                        Cadastrar
                    </button>
                </div>
            </form>
        </div>
    </main>
</body>

</html>