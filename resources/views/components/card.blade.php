@props(['card'])

@php
$cardSizeName = $card->cardSize->name . "-card";
@endphp

<div class="{{ $cardSizeName }} card">
    {{ $card->title }}
    @if($card->image)
    <img src="{{ asset( $card->image) }}" class="" alt="{{ $card->name }}" style="height: 100%; width: 100%; object-fit: cover; position: absolute">
    @elseif($card->video)
    <video controls style="height: 100%; width:100%; position: absolute" type="video/mp4; codecs=h264">
        <source src="{{ asset($card->video) }}"/>
    </video>
    @endif

    @if($card->categories->count() > 0)
    <div class="card__categories">
        @foreach($card->categories as $category)
        <a href="{{ route('home', ['category' => $category->id]) }}" class="badge m-1 bg-secondary text-decoration-none card__categories_category">{{ $category->name }}</a>
        @endforeach
    </div>
    @endif

</div>