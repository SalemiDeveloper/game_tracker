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
    <title>Teste View</title>
</head>
<body>
    <h1>Meus jogos</h1>

    <p>Lista de jogos que já zerei.</p>

    <ul>
        <?php foreach($games as $game): ?>
            <li>
                <?= htmlspecialchars($game['titulo']) ?> 
            - Nota: <?= htmlspecialchars($game['nota']) ?>

                <a href="/games/edit?id=<?= htmlspecialchars($game['id'] ?? '') ?>">Editar</a>

                <a href="/games/delete?id=<?= htmlspecialchars($game['id'] ?? '') ?>">
                    Deletar
                </a>
            </li>
        <?php endforeach; ?>
    </ul>

    

    <h2>Adicionar novo jogo</h2>

    <form method="POST" action="/games">
        <div style="margin-bottom: 10px;">
            <input name="titulo" placeholder="Título"
                value="<?= htmlspecialchars($_SESSION['old']['titulo'] ?? '') ?>">
            <?php if ($msg = error('titulo')): ?>
                <p style="color:red;"><?= htmlspecialchars($msg) ?></p>
            <?php endif; ?>
        </div>

        <div style="margin-bottom: 10px;">
            <input name="nota" placeholder="0 a 10"
                value="<?= htmlspecialchars($_SESSION['old']['nota'] ?? '') ?>">
            <?php if ($msg = error('nota')): ?>
                <p style="color:red;"><?= htmlspecialchars($msg) ?></p>
            <?php endif; ?>
        </div>

        <button type="submit">Salvar</button>
    </form>
    <?php 
    unset($_SESSION['old']); 
    unset($_SESSION['errors']); 
    ?>
</body>
</html>