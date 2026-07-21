document.addEventListener('DOMContentLoaded', init);

// incia a página
function init() {
    const button = document.getElementById('search-game');
    const preview = document.getElementById('game-preview');
    const titleInput = document.getElementById('titulo');
    const platformSelect = document.getElementById('plataforma');
    const genreSelect = document.getElementById('genero');

    if (!button || !preview || !titleInput) {
        return;
    }

    button.addEventListener('click', () =>
        handleSearch({
            titleInput,
            preview,
            platformSelect,
            genreSelect,
        })
    );
}

// coordena a busca do jogo
async function handleSearch({
    titleInput,
    preview,
    platformSelect,
    genreSelect,
}) {
    const title = titleInput.value.trim();
    
    if (!title) {
        alert('Informe um título!');
        return;
    }

    try {
        const games = await searchGames(title);
        renderSearchResults({
            games,
            titleInput,
            preview,
            platformSelect,
            genreSelect
        });

    } catch (error) {
        showError(preview);
        console.error(error);
    }
}

// função que conversa com a API
async function searchGames(title) {

    const response = await fetch(
        `/api/metadata/game?title=${encodeURIComponent(title)}`
    );

    if (!response.ok) {
        throw new Error('Erro ao buscar informações do jogo.');
    }

    return await response.json();
}

async function loadGame(id) {
    const response = await fetch(
        `/api/metadata/game/details?id=${id}`
    );

    if (!response.ok) {
        throw new Error('Erro ao carregar jogo.');
    }

    return await response.json();
}

// atualiza a interface
function updateUI({game, titleInput, preview, platformSelect, genreSelect}) {
    renderGamePreview(game, preview);
    fillForm(game, titleInput, platformSelect, genreSelect);
}

// renderiza o card na tela
function renderGamePreview(game, preview) {
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

function renderSearchResults({
    games,
    titleInput,
    preview,
    platformSelect,
    genreSelect
}) {
    const container = document.getElementById('search-results');

    container.innerHTML = '';

    if (games.length === 0) {
        container.innerHTML = `
            <p>Nenhum jogo encontrado.</p>
        `;

        return;
    }

    const select = document.createElement('select');

    select.id = 'game-results';
    select.className = 'form-select';

    select.innerHTML = `
        <option value="">
            Selecione um jogo...
        </option>
    `;

    games.forEach(game => {
        const option = document.createElement('option');

        option.value = game.external_id;

        option.textContent =
            `${game.title} (${game.released ?? 'Sem data'})`;

        select.appendChild(option);
    });

    select.addEventListener('change', async (event) => {

        const id = event.target.value;

        if (!id) {
            return;
        }

        try {

            const game = await loadGame(id);
                console.log(game);
            updateUI({game, titleInput, preview, platformSelect, genreSelect});

        } catch (error) {
            console.error(error);
        }

    });

    container.appendChild(select);
}

// preenche os campos
function fillForm(game, titleInput, platformSelect, genreSelect) {
    titleInput.value = game.title;
    const externalIdInput = document.getElementById('external_id');

    if (externalIdInput) {
        externalIdInput.value = game.external_id ?? '';
    }

    if (platformSelect && game.platforms.length > 0) {
        platformSelect.value = game.platforms[0];
    }

    if (genreSelect && game.genres.length > 0) {
        genreSelect.value = game.genres[0];
    }
}

// as funções abaixo são autoexplicativas
function showError(preview) {
    preview.innerHTML = `
        <div class="alert alert-error">
            Não foi possível encontrar esse jogo.
        </div>
    `;
}
function formatDate(date) {
    if (!date) {
        return 'Não informado';
    }

    return new Date(date).toLocaleDateString('pt-BR');
}