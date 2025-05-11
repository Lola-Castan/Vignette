@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Créer une carte</h2>
    <form action="{{ route('cards_store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Titre</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image (JPG, PNG)</label>
            <input class="form-control" type="file" id="image" name="image" accept="image/*">
        </div>
        <div class="mb-3">
            <label for="music" class="form-label">Son (MP3)</label>
            <input class="form-control" type="file" id="music" name="music" accept="audio/mpeg">
        </div>
        <div class="mb-3">
            <label for="video" class="form-label">Vidéo (MP4)</label>
            <input class="form-control" type="file" id="video" name="video" accept="video/mp4">
        </div>
        <div class="mb-3 text-muted">
            <small>Vous pouvez importer soit une image seule, une image + un son, ou une vidéo. Si une vidéo est choisie, l'image et le son seront ignorés.</small>
        </div>
        <button type="submit" class="btn btn-primary">Créer la carte</button>
    </form>
</div>
@endsection