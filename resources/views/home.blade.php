@extends('layouts.app')

@section('content')
<div class="page-container">
    <h2 class="">Pinterest du pauvre</h2>

    @if(count($cards) > 0)
    <div class="card-container">
        @foreach($cards as $card)
        <div class="">
            <x-card :card="$card"/>
        </div>
        @endforeach
    </div>
    <x-card-modal modalId="cardModal" :card="$card"/>
    @else
    <div class="alert alert-info">
        Aucune carte n'est disponible pour le moment.
    </div>
    @endif
</div>
@endsection