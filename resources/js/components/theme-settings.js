/**
 * Gestion des paramètres du thème dans l'interface administrateur
 */
document.addEventListener('DOMContentLoaded', function() {
    // Mise à jour de l'affichage de la valeur d'opacité
    const opacityInput = document.getElementById('opacity');
    const opacityValue = document.getElementById('opacity-value');
    
    if (opacityInput && opacityValue) {
        opacityInput.addEventListener('input', function() {
            opacityValue.textContent = Math.round(this.value * 100) + '%';
        });
    }
    
    // Mise à jour de l'aperçu de l'image sélectionnée
    const backgroundSelect = document.getElementById('background_image');
    const previewImage = document.getElementById('preview-image');
    
    if (backgroundSelect && previewImage) {
        backgroundSelect.addEventListener('change', function() {
            previewImage.src = '/storage/backgrounds/' + this.value;
        });
    }
    
    // Aperçu de la nouvelle image téléchargée
    const newImageInput = document.getElementById('new_background');
    const newImagePreview = document.getElementById('new-image-preview');
    
    if (newImageInput && newImagePreview) {
        newImageInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    newImagePreview.src = e.target.result;
                    newImagePreview.classList.remove('d-none');
                }
                
                reader.readAsDataURL(this.files[0]);
            } else {
                newImagePreview.classList.add('d-none');
            }
        });
    }
});
