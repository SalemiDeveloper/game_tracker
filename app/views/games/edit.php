<?php

use App\Helpers\StatusHelper;

function error($field)
{
    return $_SESSION['errors'][$field][0] ?? null;
}

?>

<div class="form-page">

    <div class="form-header">
        <h1>
            <i class="fa-solid fa-pen-to-square"></i>
            Editar jogo
        </h1>
        <p>Atualize as informações do jogo.</p>
    </div>

    <form method="POST" action="/games/update" class="game-form">

        <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
        <input type="hidden" name="id" value="<?= htmlspecialchars($game['id']) ?>">

        <div class="form-group">
            <label for="titulo">Título</label>
            <input
                id="titulo"
                class="form-input"
                name="titulo"
                value="<?= htmlspecialchars($_SESSION['old']['titulo'] ?? $game['titulo']) ?>"
            >
            <?php if ($msg = error('titulo')): ?>
                <p class="form-error"><?= htmlspecialchars($msg) ?></p>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="nota">Nota</label>
            <input
                id="nota"
                class="form-input"
                name="nota"
                type="number"
                min="0"
                max="10"
                step="0.1"
                value="<?= htmlspecialchars($_SESSION['old']['nota'] ?? $game['nota']) ?>"
            >
            <?php if ($msg = error('nota')): ?>
                <p class="form-error"><?= htmlspecialchars($msg) ?></p>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select
                id="status"
                name="status"
                class="form-select"
            >
                <?php foreach ($statusOptions as $status): ?>
                    <option
                        value="<?= htmlspecialchars($status) ?>"
                        <?= (($_SESSION['old']['status'] ?? $game['status']) === $status) ? 'selected' : '' ?>
                    >
                        <?= htmlspecialchars(StatusHelper::format($status)) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <?php if ($msg = error('status')): ?>
                <p class="form-error"><?= htmlspecialchars($msg) ?></p>
            <?php endif; ?>
        </div>

        <div class="form-group">

            <label for="plataforma">Plataforma</label>
            <select
                id="plataforma"
                name="plataforma"
                class="form-select"
            >
                <?php foreach ($platformOptions as $platform): ?>
                    <option
                        value="<?= htmlspecialchars($platform) ?>"
                        <?= (($_SESSION['old']['plataforma'] ?? $game['plataforma']) === $platform) ? 'selected' : '' ?>
                    >
                        <?= htmlspecialchars($platform) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <?php if ($msg = error('plataforma')): ?>
                <p class="form-error"><?= htmlspecialchars($msg) ?></p>
            <?php endif; ?>
        </div>

        <div class="form-group">

            <label for="genero">Gênero</label>
            <select
                id="genero"
                name="genero"
                class="form-select"
            >
                <?php foreach ($genreOptions as $genre): ?>
                    <option
                        value="<?= htmlspecialchars($genre) ?>"
                        <?= (($_SESSION['old']['genero'] ?? $game['genero']) === $genre) ? 'selected' : '' ?>
                    >
                        <?= htmlspecialchars($genre) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <?php if ($msg = error('genero')): ?>
                <p class="form-error"><?= htmlspecialchars($msg) ?></p>
            <?php endif; ?>

        </div>

        <div class="form-actions">
            <a href="/games" class="btn btn-secondary">
                Cancelar
            </a>
            <button type="submit" class="btn btn-primary">
                Atualizar jogo
            </button>
        </div>

    </form>
</div>

<?php
unset($_SESSION['old']);
unset($_SESSION['errors']);
?>