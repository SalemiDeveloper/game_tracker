<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teste View</title>
</head>
<body>
    <h1>Meus jogos</h1>

    <p>Lista de jogos que já zerei.</p>

    <ul>
        <?php foreach($games as $game): ?>
            <li>
                <?=  $game['titulo'] ?> - Nota: <?= $game['nota'] ?>

                <a href="/games/edit?id=<?= $game['id'] ?? '' ?>">Editar</a>

                <a href="/games/delete?id=<?= $game['id'] ?? '' ?>">
                    Deletar
                </a>
            </li>
        <?php endforeach; ?>
    </ul>

    <h2>Adicionar novo jogo</h2>

    <form method="POST" action="/games">
        <input name="titulo" placeholder="Título" required>
        <input name="nota" placeholder="Nota" required>
        <button type="submit">Salvar</button>
    </form>
</body>
</html>