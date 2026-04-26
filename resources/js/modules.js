(function () {
        const showButton = document.getElementById('show-form-btn');
        const cancelButton = document.getElementById('cancel-form-btn');
        const closeButton = document.getElementById('close-form-btn');
        const modal = document.getElementById('module-form-modal');
        if (!showButton || !modal) return;

        const openForm = () => modal.classList.add('is-open');
        const closeForm = () => modal.classList.remove('is-open');

        showButton.addEventListener('click', openForm);
        if (closeButton) {
            closeButton.addEventListener('click', closeForm);
        }
        if (cancelButton) {
            cancelButton.addEventListener('click', closeForm);
        }
        modal.addEventListener('click', function (event) {
            if (event.target === modal) {
                closeForm();
            }
        });
        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                closeForm();
            }
        });
    })();
