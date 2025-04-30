@extends('layouts.app')

@section('content')
<div class="page-container">
    <h2 class="">Pinterest du pauvre</h2>

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

    @if(count($cards) > 0)
    <div class="card-container">
        @foreach($cards as $card)
        <div class="card-clickable" data-bs-toggle="modal" data-bs-target="#cardModal-{{ $card->id }}">
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

<style>
    .category-filter {
        margin-bottom: 20px;
    }
    .category-nav {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }
    .category-item {
        padding: 8px 16px;
        background-color: #f0f0f0;
        border-radius: 20px;
        text-decoration: none;
        color: #333;
        transition: all 0.3s ease;
    }
    .category-item:hover {
        background-color: #e0e0e0;
    }
    .category-item.active {
        background-color: #007bff;
        color: white;
    }
</style>