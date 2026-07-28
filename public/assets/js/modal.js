document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('confirm-modal');
    const cancelButton = document.getElementById('cancel-delete');
    const confirmButton = document.getElementById('confirm-delete');

    let currentForm = null;

    function closeModal() {
        modal.classList.remove('active');
        currentForm = null;
    }

    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', event => {
            event.preventDefault();
            currentForm = form;

            const gameTitle = form.dataset.title;
            document.getElementById('modal-message').textContent = `Tem certeza que deseja excluir ${gameTitle}?`;

            modal.classList.add('active');
        });
    });

    cancelButton.addEventListener('click', closeModal);

    confirmButton.addEventListener('click', () => {
        if (!currentForm) {
            return;
        }
        confirmButton.disabled = true;
        currentForm.submit();
    });


    modal.addEventListener('click', (event) => {
        if (event.target === modal) {
            closeModal();
        }
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            closeModal();
        }
    });
});

