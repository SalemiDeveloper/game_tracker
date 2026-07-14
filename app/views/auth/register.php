<?php

function error($field) {
    return $_SESSION['errors'][$field][0] ?? null;
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <title>Login</title>
</head>
<body>
<div class="auth-page">
    <div class="auth-card">
        <div class="auth-header">
            <i class="fa-solid fa-user-plus auth-logo"></i>
            <h1>Criar conta</h1>
            <p>Cadastre-se para começar a organizar sua coleção de jogos.</p>
        </div>

        <form method="POST" action="/register" class="game-form">
            <input
                type="hidden"
                name="csrf"
                value="<?= $_SESSION['csrf'] ?>"
            >

            <div class="form-group">
                <label for="name">Nome</label>
                <input
                    id="name"
                    class="form-input"
                    name="name"
                    value="<?= htmlspecialchars($_SESSION['old']['name'] ?? '') ?>"
                >
                <?php if ($msg = error('name')): ?>
                    <p class="form-error"><?= htmlspecialchars($msg) ?></p>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="email">E-mail</label>
                <input
                    id="email"
                    type="email"
                    class="form-input"
                    name="email"
                    value="<?= htmlspecialchars($_SESSION['old']['email'] ?? '') ?>"
                >
                <?php if ($msg = error('email')): ?>
                    <p class="form-error"><?= htmlspecialchars($msg) ?></p>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="password">Senha</label>
                <input
                    id="password"
                    type="password"
                    class="form-input"
                    name="password"
                >
                <?php if ($msg = error('password')): ?>
                    <p class="form-error"><?= htmlspecialchars($msg) ?></p>
                <?php endif; ?>

            </div>

            <div class="form-group">
                <label for="password_confirmation">
                    Confirmar senha
                </label>
                <input
                    id="password_confirmation"
                    type="password"
                    class="form-input"
                    name="password_confirmation"
                >
                <?php if ($msg = error('password_confirmation')): ?>
                    <p class="form-error"><?= htmlspecialchars($msg) ?></p>
                <?php endif; ?>

            </div>

            <button
                type="submit"
                class="btn btn-primary auth-button"
            >
                <i class="fa-solid fa-user-plus"></i>
                Criar conta
            </button>

        </form>

        <p class="auth-footer">
            Já possui uma conta?
            <a href="/login">Entrar</a>
        </p>
    </div>
</div>
</body>
</html>

<?php

unset($_SESSION['errors']);
unset($_SESSION['old']);

?>