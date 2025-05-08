@extends('layouts.app')

@section('content')
<div class="page-container">
    <h2 class="">Vignette</h2>

    <!-- Navigation des catégories -->
    <div class="category-filter">
        <div class="category-nav">
            <a href="{{ route('home') }}" class="category-item {{ !isset($categoryId) ? 'active' : '' }}">
                Toutes les catégories
            </a>
            @foreach($categories as $category)
                <a href="{{ route('home', ['category' => $category->id]) }}" 
                    class="category-item {{ isset($categoryId) && $categoryId == $category->id ? 'active' : '' }}">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>
    </div>

    @if(Auth::check())
        <div class="mb-4 text-end">
            <a href="{{ route('cards_create') }}" class="btn btn-success">Ajouter une carte</a>
        </div>
    @endif

    @if(count($cards) > 0)
    <div class="card-container">
        @foreach($cards as $card)
        <div class="card-clickable" role="button" data-modal-id="cardModal-{{ $card->id }}">
            <x-card :card="$card"/>
        </div>
        @endforeach
    </div>
    @foreach($cards as $card)
        <x-card-modal modalId="cardModal-{{ $card->id }}" :card="$card"/>
    @endforeach
    <script>
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
    </script>
    @else
    <div class="alert alert-info">
        Aucune carte n'est disponible pour cette catégorie.
    </div>
    @endif
</div>
@endsection