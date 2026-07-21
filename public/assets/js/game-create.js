document.addEventListener('DOMContentLoaded', () => {
    const button = document.getElementById('search-game');
    const preview = document.getElementById('game-preview');

    if (!button || !preview) {
        return;
    }

    async function searchGame(title) {
        preview.innerHTML = '<p>Buscando informações...</p>';
        const response = await fetch(
            `/api/metadata/game?title=${encodeURIComponent(title)}`
        );

        if (!response.ok) {
            throw new Error('Erro ao buscar informações do jogo.');
        }

        return await response.json();
    }

    button.addEventListener('click', async () => {
        const title = document.getElementById('titulo').value;

        if (!title.trim()) {
            alert('Informe um título!');
            return;
        }

        try {
            const game = await searchGame(title);
            renderGamePreview(game);
            
        } catch (error) {
            preview.innerHTML = `
                <div class="alert alert-error">
                    Não foi possível encontrar esse jogo.
                </div>
            `;
            console.log(error);
        }
    });

    function renderGamePreview(game) {
        preview.innerHTML = `
            <div class="game-preview-card">
                <div class="game-preview-cover">
                    <img src="${game.cover}" alt="${game.title}">
                </div>

                <div class="game-preview-info">
                    <h3>${game.title}</h3>
                    <p><strong>⭐ Nota:</strong> ${game.rating}</p>
                    <p><strong>📅 Lançamento:</strong> ${game.released}</p>
                    <p>
                        <strong>🎮 Plataformas:</strong>
                        ${game.platforms.join(', ')}
                    </p>

                    <p>
                        <strong>🕹 Gêneros:</strong>
                        ${game.genres.join(', ')}
                    </p>
                </div>
            </div>
        `;
    }
});