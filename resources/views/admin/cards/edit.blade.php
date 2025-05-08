@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Modifier la taille de la carte: {{ $card->title }}</span>
                    <a href="{{ route('admin.cards.list') }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left"></i> Retour à la liste
                    </a>
                </div>

                <div class="card-body">
                    <div class="mb-4">
                        <h5>Détails de la carte</h5>
                        <p><strong>Titre:</strong> {{ $card->title }}</p>
                        <p><strong>Contenu:</strong> {{ Str::limit($card->content, 200) }}</p>
                        <p><strong>Créateur:</strong> {{ $card->user->name }}</p>
                        <p><strong>Date de création:</strong> {{ $card->created_at->format('d/m/Y à H:i') }}</p>
                        <p><strong>Taille actuelle:</strong> {{ $card->cardSize->name }} ({{ $card->cardSize->width }}x{{ $card->cardSize->height }})</p>
                    </div>

                    <form method="POST" action="{{ route('admin.cards.update', $card) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="card_size_id" class="form-label">Nouvelle taille</label>
                            <select class="form-select @error('card_size_id') is-invalid @enderror" id="card_size_id" name="card_size_id" required>
                                @foreach($cardSizes as $size)
                                    <option value="{{ $size->id }}" {{ old('card_size_id', $card->card_size_id) == $size->id ? 'selected' : '' }}>
                                        {{ $size->name }} ({{ $size->width }}x{{ $size->height }})
                                    </option>
                                @endforeach
                            </select>
                            @error('card_size_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Mettre à jour
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection