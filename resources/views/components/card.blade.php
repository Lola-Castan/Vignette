@props(['card'])

@php
$widthRatio = $card->cardSize->width;
$heightRatio = $card->cardSize->height;
$aspectRatio = ($heightRatio / $widthRatio) * 100;
@endphp

<div class="responsive-card" style="--width-ratio: {{ $widthRatio }}; --height-ratio: {{ $heightRatio }}; --aspect-ratio: {{ $aspectRatio }}%;">
    <div class="responsive-card-inner">
        @if($card->music && $card->image)
        <div style="position: relative; width: 100%; height: 100%;">
            <img src="{{ asset($card->image) }}" class="" id="{{ $card->id }}" alt="{{ $card->name }}" style="height: 100%; width: 100%; object-fit: cover; position: absolute; top: 0; left: 0; z-index: 1;">
            <audio controls preload="auto" style="height: 40px; width:100%; position: absolute; bottom: 0; left: 0; z-index: 2; background: rgba(255,255,255,0.7);">
                <source src="{{ asset($card->music) }}" type="audio/mpeg" />
                Votre navigateur ne supporte pas l'élément audio.
            </audio>
        </div>
        @elseif($card->video)
        <video controls style="height: 100%; width:100%; position: absolute" type="video/mp4; codecs=h264">
            <source src="{{ asset($card->video) }}" />
        </video>
        @elseif($card->image)
        <img src="{{ asset( $card->image) }}" class="" id="{{ $card->id }}" alt="{{ $card->name }}" style="height: 100%; width: 100%; object-fit: cover; position: absolute">
        @elseif($card->music)
        <audio controls preload="auto" style="height: 100%; width:100%; position: absolute">
            <source src="{{ asset($card->music) }}" type="audio/mpeg" />
            Votre navigateur ne supporte pas l'élément audio.
        </audio>        @endif

        @if($card->categories->count() > 0)
        <div class="card__categories position-absolute" style="bottom: 10px; left: 10px; z-index: 100;">
            @foreach($card->categories as $category)
            @php
                $categoryUrl = route('home', ['category' => $category->id]);
            @endphp
            <a href="{{ $categoryUrl }}"
                class="badge m-1 bg-secondary text-decoration-none card__categories_category"
                style="font-size: 0.85rem; padding: 5px 8px;"
                onclick="event.stopPropagation(); event.preventDefault(); window.location.href='{{ $categoryUrl }}';">
                {{ $category->name }}
            </a>
            @endforeach
        </div>
        @endif
        
        <div class="card__magic-number position-absolute" style="top: 5px; right: 5px; z-index: 1000; pointer-events: auto;">
            @php
                $magicNumberUrl = route('home', ['magic_number' => $card->user->magic_number]);
            @endphp
            <a href="{{ $magicNumberUrl }}"
                class="badge bg-dark text-decoration-none"
                style="position: relative; z-index: 1000; pointer-events: auto;"
                onclick="event.stopPropagation(); event.preventDefault(); window.location.href='{{ $magicNumberUrl }}';">
                #{{ $card->user->magic_number ?? 'N/A' }}
            </a>
        </div>
    </div>
</div>