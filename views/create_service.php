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

            <form action="/create-service" method="POST">
                <div class="form-group">
                    <label for="service_description">
                        Descrição
                    </label>
                    <input type="text" id="description" name="description" placeholder="Descrição do Serviço"
                        value="<?= htmlspecialchars($_POST['description'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label for="price">
                        Preço
                    </label>
                    <input type="number" step="0.01" id="price" name="price" placeholder="Preço do Serviço"
                        value="<?= htmlspecialchars($_POST['price'] ?? '') ?>">
                </div>
                <div class="actions">
                    <button type="submit" class="submit-button">
                        Cadastrar
                    </button>
                </div>
            </form>
        </div>
    </main>
</body>

</html>