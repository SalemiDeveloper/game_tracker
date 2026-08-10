document.addEventListener('DOMContentLoaded', init);
let searchController = null;
let selectedTitle = '';

// incia a página
function init() {
    const preview = document.getElementById('game-preview');
    const titleInput = document.getElementById('titulo');
    const externalIdInput = document.getElementById('external_id');
    const platformSelect = document.getElementById('plataforma');
    const genreSelect = document.getElementById('genero');

    if (!titleInput) {
        return;
    }

    titleInput.addEventListener('input', () => {
        if (externalIdInput && titleInput.value !== selectedTitle) {
            externalIdInput.value = '';
        }
    });

    if (preview) {
        let debounce;
        titleInput.addEventListener('input', () => {
            clearTimeout(debounce);
            const title = titleInput.value.trim();
            if (title.length < 3) {
                document.getElementById('search-results').innerHTML = '';
                return;
            }

            debounce = setTimeout(() => {
                handleSearch({
                    titleInput,
                    preview,
                    platformSelect,
                    genreSelect
                });
            }, 800);
        });
    }

    const statusSelect = document.getElementById('status');
    statusSelect.addEventListener('change', toggleGameFieldsRequirement);
    toggleGameFieldsRequirement();

    document.addEventListener('click', (event) => {
        const container = document.getElementById('search-results');

        if (!container.contains(event.target) &&event.target !== titleInput) {
            container.innerHTML = '';

            if (searchController) {
                searchController.abort();
            }
        }
    });
}

// coordena a busca do jogo
async function handleSearch({
    titleInput,
    preview,
    platformSelect,
    genreSelect,
}) {

    const title = titleInput.value.trim();

    if (title.length < 3) {
        document.getElementById('search-results').innerHTML = '';
        return;
    }

    try {
        showLoading();
        const games = await searchGames(title);

        if (games.length === 0) {
            document.getElementById('search-results').innerHTML = '';
            return;
        }

        renderSearchResults({
            games,
            titleInput,
            preview,
            platformSelect,
            genreSelect
        });

    } catch (error) {

        console.error(error);
        showError(preview);

    }
}

// função que conversa com a API
async function searchGames(title) {

    // Cancela a busca anterior, se ainda estiver em andamento
    if (searchController) {
        searchController.abort();
    }

    // Cria um novo controller para esta requisição
    searchController = new AbortController();

    try {

        const response = await fetch(
            `/api/metadata/game?title=${encodeURIComponent(title)}`,
            {
                signal: searchController.signal
            }
        );

        if (!response.ok) {
            throw new Error('Erro ao buscar informações do jogo.');
        }

        return await response.json();

    } catch (error) {

        // Ignora erros causados pelo cancelamento da requisição
        if (error.name === 'AbortError') {
            return [];
        }
        throw error;
    }
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
            <div class="search-result-empty">
                Nenhum jogo encontrado.
            </div>
        `;
        return;
    }

    games.forEach(game => {

        const item = document.createElement('div');
        item.className = 'search-result-item';

        const cover = game.cover || '/assets/images/default-cover.png';

        item.innerHTML = `
            <img
                src="${cover}"
                alt="${game.title}"
                class="search-result-cover"
            >

            <div class="search-result-info">
                <div class="search-result-title">
                    ${game.title}
                </div>

                <div class="search-result-date">
                    ${formatDate(game.released)}
                </div>
            </div>
        `;

        item.addEventListener('click', async () => {

            try {

                const fullGame = await loadGame(game.external_id);

                updateUI({
                    game: fullGame,
                    titleInput,
                    preview,
                    platformSelect,
                    genreSelect
                });

                container.innerHTML = '';

            } catch (error) {
                console.error(error);
            }

        });

        container.appendChild(item);

    });
}

// preenche os campos
function fillForm(game, titleInput, platformSelect, genreSelect) {
    titleInput.value = game.title;
    selectedTitle = game.title;
    document.getElementById('search-results').innerHTML = '';
    const externalIdInput = document.getElementById('external_id');
    const coverInput = document.getElementById('cover');

    if (externalIdInput) {
        externalIdInput.value = game.external_id ?? '';
    }
    if (coverInput) {
        coverInput.value = game.cover ?? '';
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
            <i class="fa-solid fa-circle-xmark"></i>
            Não foi possível encontrar esse jogo.
        </div>
    `;
}

function showLoading() {

    const container = document.getElementById('search-results');

    container.innerHTML = `
        <div class="search-result-loading">
            <i class="fa-solid fa-spinner fa-spin"></i>
            Buscando jogos...
        </div>
    `;
}

function formatDate(date) {
    if (!date) {
        return 'Não informado';
    }

    return new Date(date).toLocaleDateString('pt-BR');
}

function toggleGameFieldsRequirement() {
    const statusSelect = document.getElementById('status');
    const ratingInput = document.getElementById('nota');
    const hoursInput = document.getElementById('horas_jogadas');

    if (!statusSelect) {
        return;
    }

    const disabled = statusSelect.value === 'backlog' || statusSelect.value === 'jogando';

    if (ratingInput) {
        ratingInput.required = !disabled;
        ratingInput.disabled = disabled;

        if (disabled) {
            ratingInput.value = '';
            ratingInput.placeholder = 'Não se aplica';
        } else {
            ratingInput.placeholder = '0 a 10';
        }
    }

    if (hoursInput) {
        hoursInput.required = !disabled;
        hoursInput.disabled = disabled;

        if (disabled) {
            hoursInput.value = '';
            hoursInput.placeholder = 'Não se aplica';
        } else {
            hoursInput.placeholder = 'Horas jogadas';
        }
    }
}