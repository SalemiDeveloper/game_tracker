<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Tracker</title>

</head>
<body>
    <hr>

    <?php if (!empty($_SESSION['success'])): ?>
        <p style="color: green;">
            <?= $_SESSION['success'] ?>
        </p>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>
    <?php require $content; ?>
</body>
</html>