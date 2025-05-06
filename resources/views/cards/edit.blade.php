@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Modifier la carte</h2>
    <form action="{{ route('cards_update', $card->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="title" class="form-label">Titre</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $card->title) }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $card->description) }}</textarea>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image (JPG, PNG)</label>
            <input class="form-control" type="file" id="image" name="image" accept="image/*">
            @if($card->image)
                <div class="mt-2"><img src="{{ asset($card->image) }}" alt="Image actuelle" style="max-width: 150px;"></div>
            @endif
        </div>
        <div class="mb-3">
            <label for="music" class="form-label">Son (MP3)</label>
            <input class="form-control" type="file" id="music" name="music" accept="audio/mpeg">
            @if($card->music)
                <div class="mt-2"><audio controls src="{{ asset($card->music) }}" style="max-width: 150px;"></audio></div>
            @endif
        </div>
        <div class="mb-3">
            <label for="video" class="form-label">Vidéo (MP4)</label>
            <input class="form-control" type="file" id="video" name="video" accept="video/mp4">
            @if($card->video)
                <div class="mt-2"><video controls src="{{ asset($card->video) }}" style="max-width: 150px;"></video></div>
            @endif
        </div>
        <div class="mb-3 text-muted">
            <small>Vous pouvez importer soit une image seule, une image + un son, ou une vidéo. Si une vidéo est choisie, l'image et le son seront ignorés.</small>
        </div>
        <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
    </form>
</div>
<script>
const videoInput = document.getElementById('video');
const imageInput = document.getElementById('image');
const musicInput = document.getElementById('music');
if(videoInput) {
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
</script>
@endsection
