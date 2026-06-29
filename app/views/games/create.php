<?php

use App\Helpers\StatusHelper;


function error($field) {
    return $_SESSION['errors'][$field][0] ?? null;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Tracker</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <h1>Novo Jogo</h1>

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
            <select name="status">

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

    <p>
        <a href="/games">← Voltar para meus jogos</a>
    </p>
</body>
</html>

<?php 
unset($_SESSION['old']); 
unset($_SESSION['errors']);