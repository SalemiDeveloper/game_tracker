
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teste View</title>
</head>
<body>

    <p>Olá,
        <?=  htmlspecialchars($_SESSION['user']['name']) ?>
    </p>

    <form method="POST" action="/logout">
        <input type="hidden"
               name="csrf"
               value="<?= $_SESSION['csrf'] ?>">

        <button type="submit">
            Sair
        </button>
    </form>

    <h1>Meus jogos</h1>

    <p>Lista de jogos que já zerei.</p>

    <ul>
        <?php foreach($games as $game): ?>
            <li>
                <?= htmlspecialchars($game['titulo']) ?> 
            - Nota: <?= htmlspecialchars($game['nota']) ?>

                <a href="/games/edit?id=<?= htmlspecialchars($game['id'] ?? '') ?>">Editar</a>

                <form method="POST" action="/games/delete">
                    <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($game['id']) ?>">
                    <button type="submit">Deletar</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>

    

    <h2>Adicionar novo jogo</h2>

    <p>
        <a
            href="/games/create"
            style="
                display:inline-block;
                padding:10px 16px;
                background:#2563eb;
                color:white;
                text-decoration:none;
                border-radius:6px;
                margin-bottom:20px;
            "
        >
            + Novo jogo
        </a>
    </p>
    <?php 
    unset($_SESSION['old']); 
    unset($_SESSION['errors']);
    ?>
</body>
</html>