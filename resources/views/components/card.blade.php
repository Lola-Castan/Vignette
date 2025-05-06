@props(['card'])

@php
$cardSizeName = $card->cardSize->name . "-card";
@endphp

<div class="{{ $cardSizeName }} card">
    @if($card->music && $card->image)
    <div style="position: absolute; width: 100%; height: 100%;">
        <img src="{{ asset($card->image) }}" class="" id="{{ $card->id }}" alt="{{ $card->name }}" style="height: 100%; width: 100%; object-fit: cover; position: absolute; top: 0; left: 0; z-index: 1;">
        <audio controls preload="auto" style="height: 40px; width:100%; position: absolute; bottom: 0; left: 0; z-index: 2; background: rgba(255,255,255,0.7);">
            <source src="{{ asset($card->music) }}" type="audio/mpeg"/>
            Votre navigateur ne supporte pas l'élément audio.
        </audio>
    </div>
    @elseif($card->video)
    <video controls style="height: 100%; width:100%; position: absolute" type="video/mp4; codecs=h264">
        <source src="{{ asset($card->video) }}"/>
        </video>
    @elseif($card->image)
    <img src="{{ asset( $card->image) }}" class="" id="{{ $card->id }}" alt="{{ $card->name }}" style="height: 100%; width: 100%; object-fit: cover; position: absolute">
    @elseif($card->music)
    <audio controls preload="auto" style="height: 100%; width:100%; position: absolute">
        <source src="{{ asset($card->music) }}" type="audio/mpeg"/>
        Votre navigateur ne supporte pas l'élément audio.
    </audio>
    @endif

    @if($card->categories->count() > 0)
    <div class="card__categories">
        @foreach($card->categories as $category)
        <a href="{{ route('home', ['category' => $category->id]) }}" class="badge m-1 bg-secondary text-decoration-none card__categories_category">{{ $category->name }}</a>
        @endforeach
    </div>
    @endif

</div>