<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Jogos</title>
</head>
<body>
    <h1>Editar Jogo</h1>

    <form method="POST" action="/games/update">
        <input type="hidden" name="id" value="<?= $game['id'] ?>">

        <input name="titulo" value="<?= $game['titulo'] ?>">
        <input name="nota" value="<?= $game['nota'] ?>">

        <button type="submit">Atualizar</button>
    </form>
</body>
</html>