document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('confirm-modal');
    const cancelButton = document.getElementById('cancel-delete');
    const confirmButton = document.getElementById('confirm-delete');

    let currentForm = null;

    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', event => {
            event.preventDefault();
            currentForm = true;
            modal.classList.add('active');
        });
    });

    cancelButton.addEventListener('click', () => {
        modal.classList.remove('active');
        currentForm = false;

        confirmButton.addEventListener('click', () => {
            if (currentForm) {
                currentForm.submit();
            }
        });
    });
});