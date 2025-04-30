@props(['card', 'modalId'])

<div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-labelledby="{{ $modalId }}Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{ $modalId }}Label">{{ $card->title ?? $card->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body text-center">
                @if($card->image)
                <img src="{{ asset($card->image) }}" class="img-fluid mb-3 card-modal-media-image" alt="{{ $card->title ?? $card->name }}">
                @elseif($card->music)
                <audio controls class="mb-3">
                    <source src="{{ asset($card->music) }}">
                    Votre navigateur ne supporte pas l'audio.
                </audio>
                @elseif($card->video)
                <video controls preload="auto" class="img-fluid mb-3 card-modal-media-video">
                    <source src="{{ asset($card->video) }}">
                    Votre navigateur ne supporte pas la vidéo.
                </video>
                @endif
                <div class="modal-body__right">
                    <p>{{ $card->description }}</p>
                    <div>
                        <p><strong>Magic number:</strong> {{ $card->user->magic_number ?? '' }}</p>
                        @if($card->categories->count() > 0)
                        <div>
                            @foreach($card->categories as $category)
                            <span class="badge bg-secondary">{{ $category->name }}</span>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>