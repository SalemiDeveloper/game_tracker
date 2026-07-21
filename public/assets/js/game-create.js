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

        const cover = game.cover || '/assets/images/default-cover.png';
        preview.innerHTML = `
            <div class="game-preview-card">

                <img
                    class="game-preview-cover"
                    src="${cover}"
                    alt="${game.title}"
                >

                <div class="game-preview-info">
                    <h3>${game.title}</h3>
                    <div class="game-preview-meta">
                        ⭐ ${game.rating ? game.rating.toFixed(1) : 'N/A'}
                    </div>

                    <div class="game-preview-meta">
                        📅 ${formatDate(game.released)}
                    </div>

                    <div class="game-preview-meta">
                        🎮 ${game.platforms.join(', ')}
                    </div>

                    <div class="game-preview-meta">
                        🕹 ${game.genres.join(', ')}
                    </div>
                </div>
            </div>
        `;
    }

    function formatDate(date) {
        if (!date) {
            return 'Não informado';
        }

        return new Date(date).toLocaleDateString('pt-BR');
    }

});


