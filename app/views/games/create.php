<?php

use App\Helpers\StatusHelper;

function error($field) {
    return $_SESSION['errors'][$field][0] ?? null;
}
?>

<div class="form-page">
    <div class="form-header">
        <h1>Novo jogo</h1>
        <p>Preencha as informações abaixo para adicionar um jogo à sua biblioteca.</p>
    </div>

    <form method="POST" action="/games" class="game-form">
        <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">

        <div class="form-group">
            <label for="titulo">Título</label>
            <input
                id="titulo"
                class="form-input"
                name="titulo"
                placeholder="Ex.: The Witcher 3"
                value="<?= htmlspecialchars($_SESSION['old']['titulo'] ?? '') ?>"
            >

             <button
                type="button"
                id="search-game"
                class="btn btn-secondary"
            >
                <i class="fa-solid fa-magnifying-glass"></i>
                
                Buscar
            </button>
            <?php if ($msg = error('titulo')): ?>
                <p class="form-error"><?= htmlspecialchars($msg) ?></p>
            <?php endif; ?>
        </div>

        <div id="game-preview"></div>

        <div class="form-group">
            <label for="nota">Sua Nota</label>
            <input 
                id="nota"
                class="form-input"
                name="nota"
                type="number"
                min="0"
                max="10"
                step="0.1"
                placeholder="Ex.: 10"
                value="<?= htmlspecialchars($_SESSION['old']['nota'] ?? '') ?>">
            <?php if ($msg = error('nota')): ?>
                <p style="color:red;"><?= htmlspecialchars($msg) ?></p>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select 
                id="status"
                name="status"
                class="form-select">

                <option value="">Selecione um status</option>

                <?php foreach ($statusOptions as $status): ?>

                    <option
                        value="<?= htmlspecialchars($status) ?>"
                        <?= (($_SESSION['old']['status'] ?? '') === $status) ? 'selected' : '' ?>
                    >
                        <?= htmlspecialchars(StatusHelper::format($status)) ?>
                    </option>

                <?php endforeach; ?>

            </select>

            <?php if ($msg = error('status')): ?>
                <p style="color:red;">
                    <?= htmlspecialchars($msg) ?>
                </p>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="plataforma">Plataforma</label>
            <select
                id="plataforma"
                name="plataforma"
                class="form-select"
            >
                <option value="">Selecione uma plataforma</option>
                <?php foreach ($platformOptions as $platform): ?>
                    <option
                        value="<?= htmlspecialchars($platform) ?>"
                        <?= (($_SESSION['old']['plataforma'] ?? '') === $platform) ? 'selected' : '' ?>
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
                <option value="">Selecione um gênero</option>
                <?php foreach ($genreOptions as $genre): ?>
                    <option
                        value="<?= htmlspecialchars($genre) ?>"
                        <?= (($_SESSION['old']['genero'] ?? '') === $genre) ? 'selected' : '' ?>
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
            <a href="/games" class="btn btn-secondary">Cancelar</a>
            <button class="btn btn-primary" type="submit">
                Salvar jogo
            </button>
        </div>
    </form>
</div>

<script src="/assets/js/game-create.js"></script>

<?php 
unset($_SESSION['old']); 
unset($_SESSION['errors']);
