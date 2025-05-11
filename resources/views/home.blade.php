@extends('layouts.app')

@section('content')
<div class="page-container">
    <h2 class="">Vignette</h2>

    <!-- Navigation des catégories -->
    <div class="category-filter">
        <div class="category-nav">
            <a href="{{ route('home') }}" class="category-item {{ !isset($categoryId) && !isset($magicNumber) ? 'active' : '' }}">
                Toutes les catégories
            </a>
            @foreach($categories as $category)
                <a href="{{ route('home', ['category' => $category->id]) }}" 
                    class="category-item {{ isset($categoryId) && $categoryId == $category->id ? 'active' : '' }}">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>
        
        <!-- Filtrage par magic number -->
        <div class="magic-number-filter mt-3">
            <form action="{{ route('home') }}" method="GET" class="d-flex align-items-center">
                @if(isset($categoryId))
                <input type="hidden" name="category" value="{{ $categoryId }}">
                @endif
                <div class="input-group">
                    <input type="text" name="magic_number" class="form-control" placeholder="Magic number..." value="{{ $magicNumber ?? '' }}">
                    <button type="submit" class="btn btn-primary">Filtrer</button>
                    @if(isset($magicNumber))
                    <a href="{{ route('home', isset($categoryId) ? ['category' => $categoryId] : []) }}" class="btn btn-outline-secondary">Réinitialiser</a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    @if(Auth::check())
        <div class="mb-4 text-end">
            <a href="{{ route('cards_create') }}" class="btn btn-success">Ajouter une carte</a>
        </div>
    @endif

    @if(count($cards) > 0)
    <div class="mt-3 mb-3">
        @if(isset($magicNumber) && $magicNumber)
        <div class="alert alert-info">
            Affichage des cartes avec le magic number: <strong>{{ $magicNumber }}</strong>
        </div>
        @endif
    </div>
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
    @else
    <div class="alert alert-info">
        Aucune carte n'est disponible pour cette catégorie.
    </div>
    @endif
</div>
@endsection