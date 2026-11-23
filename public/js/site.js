document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.site-nav a, .site-profile, .site-brand, .button, .primary-button').forEach((element) => {
        element.addEventListener('pointerdown', () => element.classList.add('is-pressed'));
        element.addEventListener('pointerup', () => element.classList.remove('is-pressed'));
        element.addEventListener('pointerleave', () => element.classList.remove('is-pressed'));
    });

    const adminMenu = document.querySelector('.admin-menu');

    if (adminMenu) {
        document.addEventListener('click', (event) => {
            if (!adminMenu.contains(event.target)) {
                adminMenu.open = false;
            }
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                adminMenu.open = false;
            }
        });
    }
});
