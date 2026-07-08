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
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>

    <form method="POST" action="/login">
        <input type="hidden"
            name="csrf"
            value="<?= $_SESSION['csrf'] ?>">

        <div>
            <input
                name="email"
                placeholder="Email"
                value="<?= htmlspecialchars($_SESSION['old']['email'] ?? '') ?>">
        </div>

        <?php if ($msg = error('email')): ?>
            <p><?= htmlspecialchars($msg) ?></p>
        <?php endif; ?>

        <div>
            <input
                type="password"
                name="password"
                placeholder="Senha">
        </div>

        <?php if ($msg = error('password')): ?>
            <p><?= htmlspecialchars($msg) ?></p>
        <?php endif; ?>

        <button type="submit">
            Entrar
        </button>

    </form>
</body>
</html>

<?php
unset($_SESSION['errors']);
unset($_SESSION['old']);
?>
