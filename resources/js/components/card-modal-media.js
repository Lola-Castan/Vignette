/**
 * Gestion de la lecture des médias dans les modales de cartes
 */
document.addEventListener('DOMContentLoaded', function() {
    // Gérer tous les modals des cartes
    document.querySelectorAll('[id^=cardModal-]').forEach(function(modal) {
        if (modal) {
            // Ajouter un événement lorsque la modale est entièrement affichée
            modal.addEventListener('shown.bs.modal', function() {
                // Trouver tous les éléments média dans cette modale spécifique
                const mediaElements = modal.querySelectorAll('.modal-media');
                
                // Démarrer la lecture de chaque élément média
                mediaElements.forEach(function(media) {
                    // Vérifier si c'est un élément audio ou vidéo
                    if (media.tagName.toLowerCase() === 'audio' || media.tagName.toLowerCase() === 'video') {
                        media.play().catch(function(error) {
                            console.log('Lecture automatique impossible: ', error);
                        });
                    }
                });
            });
            
            // Arrêter les médias lorsque la modale se ferme
            modal.addEventListener('hidden.bs.modal', function() {
                const mediaElements = modal.querySelectorAll('.modal-media');
                
                mediaElements.forEach(function(media) {
                    if (media.tagName.toLowerCase() === 'audio' || media.tagName.toLowerCase() === 'video') {
                        media.pause();
                        media.currentTime = 0;
                    }
                });
            });
        }
    });
});
