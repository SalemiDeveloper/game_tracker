<?php 
use App\Helpers\StatusHelper;

$currentSort = $filters['sort'] ?? '';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teste View</title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"/>
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

    <div class="dashboard">
        <div class="dashboard-row">
            <div class="stats-card">
                <div class="stats-card-icon total"><i class="fa-solid fa-gamepad"></i></div>
                <div class="stats-card-content">
                    <h3>Total</h3>
                    <span><?= $stats['total_games'] ?></span>
                </div>
            </div>

            <div class="stats-card">
                <div class="stats-card-icon playing"><i class="fa-solid fa-play"></i></div>
                <div class="stats-card-content">
                    <h3>Jogando</h3>
                    <span><?= $stats['jogando'] ?></span>
                </div>
            </div>

            <div class="stats-card">
                <div class="stats-card-icon finished"><i class="fa-solid fa-check"></i></div>
                <div class="stats-card-content">
                    <h3>Zerados</h3>
                    <span><?= $stats['zerados'] ?></span>
                </div>
            </div>

            <div class="stats-card">
                <div class="stats-card-icon platinum"><i class="fa-solid fa-trophy"></i></div>
                <div class="stats-card-content">
                    <h3>Platinas</h3>
                    <span><?= $stats['platinados'] ?></span>
                </div>
            </div>

        </div>
        <div class="dashboard-row three">

            <div class="stats-card">
                <div class="stats-card-icon hours"><i class="fa-regular fa-clock"></i></div>
                <div class="stats-card-content">
                    <h3>Horas</h3>
                    <span><?= $stats['horas_total'] ?></span>
                </div>
            </div>

            <div class="stats-card">
                <div class="stats-card-icon rating"><i class="fa-solid fa-star"></i></div>
                <div class="stats-card-content">
                    <h3>Média das notas</h3>
                    <span><?= $stats['nota_media'] ?></span>
                </div>
            </div>

            <div class="stats-card">
                
                <div class="stats-card-icon dropped"><i class="fa-solid fa-xmark"></i></div>
                <div class="stats-card-content">
                    <h3>Dropados</h3>
                    <span><?= $stats['dropados'] ?></span>
                </div>
            </div>
        </div>
    </div>

    <div class="toolbar">
        <form method="GET" action="/games" class="search-form">
            <input
                type="text"
                name="search"
                placeholder="Buscar jogo..."
                value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
                class="search-input"
            >

            
            <select name="status" class="search-select">
                <option value="">Todos os status</option>
                <?php foreach (StatusHelper::options() as $status): ?>
                    <option
                        value="<?= $status ?>"
                        <?= (($_GET['status'] ?? '') === $status) ? 'selected' : '' ?>
                    >
                        <?= StatusHelper::format($status) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <select name="sort" class="search-select">

                <option value="">Mais recentes</option>

                <option value="title_asc"
                    <?= $currentSort === 'title_asc' ? 'selected' : '' ?>>
                    Título (A-Z)
                </option>

                <option value="title_desc"
                    <?= $currentSort === 'title_desc' ? 'selected' : '' ?>>
                    Título (Z-A)
                </option>

                <option value="rating_desc"
                    <?= $currentSort === 'rating_desc' ? 'selected' : '' ?>>
                    Maior nota
                </option>

                <option value="rating_asc"
                    <?= $currentSort === 'rating_asc' ? 'selected' : '' ?>>
                    Menor nota
                </option>

                <option value="hours_desc"
                    <?= $currentSort === 'hours_desc' ? 'selected' : '' ?>>
                    Mais horas
                </option>

                <option value="hours_asc"
                    <?= $currentSort === 'hours_asc' ? 'selected' : '' ?>>
                    Menos horas
                </option>

            </select>

            <button type="submit" class="btn btn-primary">
                Buscar
            </button>
        </form>

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