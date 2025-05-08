@props(['card'])

@php
$widthRatio = $card->cardSize->width;
$heightRatio = $card->cardSize->height;
$aspectRatio = ($heightRatio / $widthRatio) * 100;
@endphp

<div class="responsive-card" style="--width-ratio: {{ $widthRatio }}; --height-ratio: {{ $heightRatio }}; --aspect-ratio: {{ $aspectRatio }}%;">
    <div class="responsive-card-inner">
        <!-- Média content (image, video, audio) -->
        @if($card->music && $card->image)
        <div class="card-media-container">
            <img src="{{ asset($card->image) }}" class="card-image" id="{{ $card->id }}" alt="{{ $card->name }}">
            <audio controls preload="auto" class="card-audio-player">
                <source src="{{ asset($card->music) }}" type="audio/mpeg" />
                Votre navigateur ne supporte pas l'élément audio.
            </audio>
        </div>
        @elseif($card->video)
        <video controls class="card-video-player" type="video/mp4; codecs=h264">
            <source src="{{ asset($card->video) }}" />
        </video>
        @elseif($card->image)
        <img src="{{ asset( $card->image) }}" class="card-image" id="{{ $card->id }}" alt="{{ $card->name }}">
        @elseif($card->music)
        <audio controls preload="auto" class="card-video-player">
            <source src="{{ asset($card->music) }}" type="audio/mpeg" />
            Votre navigateur ne supporte pas l'élément audio.
        </audio>
        @endif

        @if($card->categories->count() > 0)
        <div class="card__categories position-absolute">
            @foreach($card->categories as $category)
            @php
                $categoryUrl = route('home', ['category' => $category->id]);
            @endphp
            <a href="{{ $categoryUrl }}"
                class="badge bg-secondary text-decoration-none card__categories_category"
                onclick="event.stopPropagation(); event.preventDefault(); window.location.href='{{ $categoryUrl }}';"
                title="{{ $category->name }}">
                {{ $category->name }}
            </a>
            @endforeach
        </div>
        @endif
        
        <div class="card__magic-number position-absolute">
            @php
                $magicNumberUrl = route('home', ['magic_number' => $card->user->magic_number]);
            @endphp
            <a href="{{ $magicNumberUrl }}"
                class="badge bg-dark text-decoration-none card__magic-number-badge"
                onclick="event.stopPropagation(); event.preventDefault(); window.location.href='{{ $magicNumberUrl }}';">
                #{{ $card->user->magic_number ?? 'N/A' }}
            </a>
        </div>
    </div>
</div>