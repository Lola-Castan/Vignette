/**
 * Fonctionnalité pour ouvrir automatiquement la modal d'une carte
 * en fonction du paramètre URL 'card'
 */
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const cardId = urlParams.get('card');
    if(cardId) {
        const modal = document.getElementById('cardModal-' + cardId);
        if(modal) {
            // Si vous utilisez Bootstrap 5
            if(window.bootstrap) {
                const bsModal = new bootstrap.Modal(modal);
                bsModal.show();
            } else {
                // Sinon, fallback simple
                modal.style.display = 'block';
            }
        }
    }
});
