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

    <form method="POST" action="/games">
        <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
        
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

        <div style="margin-bottom: 10px;">
            <input name="status" placeholder="Vou jogar"
                value="<?= htmlspecialchars($_SESSION['old']['status'] ?? '') ?>">
            <?php if ($msg = error('status')): ?>
                <p style="color:red;"><?= htmlspecialchars($msg) ?></p>
            <?php endif; ?>
        </div>

        <div style="margin-bottom: 10px;">
            <input name="plataforma" placeholder="Digite a plataforma"
                value="<?= htmlspecialchars($_SESSION['old']['plataforma'] ?? '') ?>">
            <?php if ($msg = error('plataforma')): ?>
                <p style="color:red;"><?= htmlspecialchars($msg) ?></p>
            <?php endif; ?>
        </div>

        <div style="margin-bottom: 10px;">
            <input name="genero" placeholder="Digite o gênero"
                value="<?= htmlspecialchars($_SESSION['old']['genero'] ?? '') ?>">
            <?php if ($msg = error('genero')): ?>
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