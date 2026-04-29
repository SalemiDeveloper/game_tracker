<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Tracker</title>

    <style>
        body {
            font-family: Arial;
            margin: 40px;
            background: #f5f5f5;
        }

        nav a {
            text-decoration: none;
            font-weight: bold;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            background: white;
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <nav>
        <a href="/games">🎮 Jogos</a>
    </nav>

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