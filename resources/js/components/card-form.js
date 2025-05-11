/**
 * Gestion des formulaires de cartes (création et édition)
 * Désactive les champs image et musique lorsqu'une vidéo est sélectionnée
 */
document.addEventListener('DOMContentLoaded', function() {
    const videoInput = document.getElementById('video');
    const imageInput = document.getElementById('image');
    const musicInput = document.getElementById('music');
    
    if(videoInput && imageInput && musicInput) {
        // Vérifier l'état initial
        if(videoInput.files && videoInput.files.length > 0) {
            imageInput.disabled = true;
            musicInput.disabled = true;
        }
        
        // Ajouter l'écouteur d'événement pour les changements
        videoInput.addEventListener('change', function() {
            if(this.files.length > 0) {
                imageInput.disabled = true;
                musicInput.disabled = true;
            } else {
                imageInput.disabled = false;
                musicInput.disabled = false;
            }
        });
    }
});
