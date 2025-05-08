@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Configuration du thème avec image</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.theme.update') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="opacity">Opacité de l'image de fond</label>
                            <input type="range" 
                                   class="form-range" 
                                   min="0" 
                                   max="1" 
                                   step="0.1" 
                                   id="opacity" 
                                   name="opacity" 
                                   value="{{ $opacity }}">
                            <div class="d-flex justify-content-between">
                                <span>Transparent</span>
                                <span id="opacity-value">{{ $opacity * 100 }}%</span>
                                <span>Opaque</span>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="background_image">Image de fond actuelle</label>
                            <select class="form-select" id="background_image" name="background_image">
                                @foreach($backgroundImages as $image)
                                    <option value="{{ $image }}" {{ $image == $currentImage ? 'selected' : '' }}>
                                        {{ $image }}
                                    </option>
                                @endforeach
                            </select>
                            
                            <div class="mt-3">
                                <img id="preview-image" src="{{ asset('storage/backgrounds/' . $currentImage) }}" 
                                     class="img-thumbnail mt-2" style="max-height: 200px;" 
                                     alt="Image de fond actuelle">
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="new_background">Télécharger une nouvelle image</label>
                            <input type="file" class="form-control" id="new_background" name="new_background" accept="image/*">
                            <div class="form-text">Formats acceptés : JPG, PNG, GIF - Taille max : 2 Mo</div>
                            
                            <div class="mt-3">
                                <img id="new-image-preview" src="#" 
                                     class="img-thumbnail mt-2 d-none" 
                                     style="max-height: 200px;" 
                                     alt="Aperçu de la nouvelle image">
                            </div>
                        </div>

                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary">
                                Enregistrer les modifications
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mise à jour de l'affichage de la valeur d'opacité
        const opacityInput = document.getElementById('opacity');
        const opacityValue = document.getElementById('opacity-value');
        
        opacityInput.addEventListener('input', function() {
            opacityValue.textContent = Math.round(this.value * 100) + '%';
        });
        
        // Mise à jour de l'aperçu de l'image sélectionnée
        const backgroundSelect = document.getElementById('background_image');
        const previewImage = document.getElementById('preview-image');
        
        backgroundSelect.addEventListener('change', function() {
            previewImage.src = '/storage/backgrounds/' + this.value;
        });
        
        // Aperçu de la nouvelle image téléchargée
        const newImageInput = document.getElementById('new_background');
        const newImagePreview = document.getElementById('new-image-preview');
        
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
    });
</script>
@endsection