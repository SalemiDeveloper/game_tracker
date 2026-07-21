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
     <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <title>Login</title>
</head>
<body>
    <div class="auth-page">
        <div class="auth-card">
            <div class="auth-header">
                <h1>
                    <i class="fa-solid fa-gamepad"></i>
                    Game Tracker
                </h1>
                <p>Organize sua coleção de jogos.</p>
            </div>
            <form method="POST" action="/login" class="game-form">
                <input type="hidden"
                    name="csrf"
                    value="<?= $_SESSION['csrf'] ?>">

                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input
                        id="email"
                        class="form-input"
                        type="email"
                        name="email"
                        value="<?= htmlspecialchars($_SESSION['old']['email'] ?? '') ?>"
                    >

                    <?php if ($msg = error('email')): ?>
                        <p class="form-error"><?= htmlspecialchars($msg) ?></p>
                    <?php endif; ?>
                </div>

                <?php if ($msg = error('email')): ?>
                    <p><?= htmlspecialchars($msg) ?></p>
                <?php endif; ?>

                <div class="form-group">
                    <label for="password">Senha</label>
                    <input
                        id="password"
                        class="form-input"
                        type="password"
                        name="password"
                    >
                    <?php if ($msg = error('password')): ?>
                        <p class="form-error"><?= htmlspecialchars($msg) ?></p>
                    <?php endif; ?>
                </div>

                <?php if ($msg = error('password')): ?>
                    <p><?= htmlspecialchars($msg) ?></p>
                <?php endif; ?>

                <button class="btn btn-primary auth-button" type="submit">
                    <i class="fa-solid fa-right-to-bracket"></i>
                    Entrar
                </button>

                <p class="auth-footer">
                    Ainda não possui uma conta?
                    <a href="/register">Criar conta</a>
                </p>
            </form>
        </div>
    </div>
</body>
</html>

<?php
unset($_SESSION['errors']);
unset($_SESSION['old']);
?>
