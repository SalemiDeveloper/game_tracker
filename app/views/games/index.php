<?php 
use App\Helpers\StatusHelper;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teste View</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
<div class="container">
    <p>Olá,
        <?=  htmlspecialchars($_SESSION['user']['name']) ?>
    </p>

    <div class="actions">

        <h2>Seus jogos</h2>

        <a
            href="/games/create"
            class="btn btn-primary"
        >
            + Novo jogo
        </a>

    </div>
    <form method="POST" action="/logout">
        <input type="hidden"
               name="csrf"
               value="<?= $_SESSION['csrf'] ?>">

        <button type="submit">
            Sair
        </button>
    </form>

    <div class="dashboard">

        <div class="card">
            <h3>Total</h3>
            <span><?= $stats['total_games'] ?></span>
        </div>

        <div class="card">
            <h3>Jogando</h3>
            <span><?= $stats['jogando'] ?></span>
        </div>

        <div class="card">
            <h3>Zerados</h3>
            <span><?= $stats['zerados'] ?></span>
        </div>

        <div class="card">
            <h3>Platinas</h3>
            <span><?= $stats['platinados'] ?></span>
        </div>

        <div class="card">
            <h3>Dropados</h3>
            <span><?= $stats['dropados'] ?></span>
        </div>

        <div class="card">
            <h3>Média</h3>
            <span><?= $stats['nota_media'] ?></span>
        </div>

        <div class="card">
            <h3>Horas</h3>
            <span><?= $stats['horas_total'] ?></span>
        </div>
    </div>

    <div class="games-list">
    <?php foreach ($games as $game): ?>

        <div class="game-card">
            <div class="game-info">
                <h3><?= htmlspecialchars($game['titulo']) ?></h3>

                <div class="game-meta">
                    <span>⭐ <?= htmlspecialchars($game['nota']) ?></span>
                    <span>🎮 <?= htmlspecialchars($game['plataforma']) ?></span>
                    <span>🗂 <?= htmlspecialchars($game['genero']) ?></span>
                </div>

                <span class="badge badge-<?= htmlspecialchars($game['status']) ?>">
                    <?= htmlspecialchars(StatusHelper::format($game['status'])) ?>
                </span>
            </div>

            <div class="game-actions">

                <a class="btn btn-primary" href="/games/edit?id=<?= $game['id'] ?>">
                    Editar
                </a>

                <form method="POST" action="/games/delete">

                    <input
                        type="hidden"
                        name="csrf"
                        value="<?= $_SESSION['csrf'] ?>"
                    >

                    <input
                        type="hidden"
                        name="id"
                        value="<?= $game['id'] ?>"
                    >

                    <button
                        class="btn btn-danger"
                    >
                        Excluir
                    </button>

                </form>
            </div>
        </div>
    <?php endforeach; ?>

</div>
    <?php 
    unset($_SESSION['old']); 
    unset($_SESSION['errors']);
    ?>
</div>
</body>
</html>