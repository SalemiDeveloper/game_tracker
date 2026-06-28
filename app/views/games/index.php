
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

    <div style="
        display: flex;
        gap: 16px;
        flex-wrap: wrap;
        margin-bottom: 30px;
    ">

        <div class="card">
            <h3>Total</h3>
            <p><?= $stats['total_games'] ?></p>
        </div>

        <div class="card">
            <h3>Jogando</h3>
            <p><?= $stats['jogando'] ?></p>
        </div>

        <div class="card">
            <h3>Zerados</h3>
            <p><?= $stats['zerados'] ?></p>
        </div>

        <div class="card">
            <h3>Platinas</h3>
            <p><?= $stats['platinados'] ?></p>
        </div>

        <div class="card">
            <h3>Dropados</h3>
            <p><?= $stats['dropados'] ?></p>
        </div>

        <div class="card">
            <h3>Média das notas</h3>
            <p><?= $stats['nota_media'] ?></p>
        </div>

        <div class="card">
            <h3>Horas</h3>
            <p><?= $stats['horas_total'] ?></p>
        </div>

    </div>

    

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

<style>

.card{
    width:160px;
    padding:20px;
    border:1px solid #ddd;
    border-radius:8px;
    background:#fafafa;
    text-align:center;
}

.card h3{
    margin:0 0 10px;
    font-size:16px;
}

.card p{
    margin:0;
    font-size:28px;
    font-weight:bold;
}

</style>