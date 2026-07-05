<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Tracker</title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body>

<header class="header">

    <div class="logo">🎮 Game Tracker</div>

    <div class="header-right">
        <span>Olá,<?= htmlspecialchars($_SESSION['user']['name']) ?></span>

        <form method="POST" action="/logout">

            <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
            <button class="btn btn-danger" type="submit">
                Sair
            </button>
        </form>
    </div>
</header>

<div class="container">
    <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert-success">
            <?= htmlspecialchars($_SESSION['success']) ?>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>
    <?php require $content; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {

    const scrollPosition = sessionStorage.getItem('scrollPosition');
    if (scrollPosition !== null) {
        window.scrollTo({
            top: Number(scrollPosition),
            behavior: 'smooth'
        });

        sessionStorage.removeItem('scrollPosition');
    }
});
</script>

</body>
</html>