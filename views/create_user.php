<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Usuário</title>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
    <main class="container">
        <div class="box">
            <h1>Cadastrar Novo Usuário</h1>

            <?php if (isset($error)): ?>
            <div class="error-message">
                <?= htmlspecialchars($error) ?>
            </div>
            <?php endif; ?>

            <form action="/create-user" method="POST">
                <div class="form-group">
                    <label for="email">
                        E-mail
                    </label>
                    <input type=" email" id="email" name="email" placeholder="email@email.com"
                        value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label for="password">
                        Senha
                    </label>
                    <input type="password" id="password" name="password" placeholder="****************">
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