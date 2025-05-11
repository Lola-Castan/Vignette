@props(['card', 'modalId'])

<div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-labelledby="{{ $modalId }}Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{ $modalId }}Label">{{ $card->title ?? $card->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body text-center">
                @if($card->music && $card->image)
                <div class="card-modal-media-container">
                    <img src="{{ asset($card->image) }}" class="img-fluid mb-5 card-modal-media-image" alt="{{ $card->title ?? $card->name }}">
                    <audio controls preload="auto" class="card-audio-player modal-media">
                        <source src="{{ asset($card->music) }}">
                        Votre navigateur ne supporte pas l'élément audio.
                    </audio>
                </div>
                @elseif($card->image)
                <img src="{{ asset($card->image) }}" class="img-fluid mb-3 card-modal-media-image" alt="{{ $card->title ?? $card->name }}">
                @elseif($card->music)
                <audio controls preload="auto" class="mb-3 modal-media">
                    <source src="{{ asset($card->music) }}">
                    Votre navigateur ne supporte pas l'audio.
                </audio>
                @elseif($card->video)
                <video controls preload="auto" class="img-fluid mb-3 card-modal-media-video modal-media">
                    <source src="{{ asset($card->video) }}">
                    Votre navigateur ne supporte pas la vidéo.
                </video>
                @endif
                <div class="modal-body__right">
                    <p>{{ $card->description }}</p>
                    <div>
                        <p>
                            <strong>Magic number:</strong> 
                            <a href="{{ route('home', ['magic_number' => $card->user->magic_number]) }}" class="badge bg-secondary">
                                {{ $card->user->magic_number ?? 'N/A' }}
                            </a>
                        </p>
                        @if($card->categories->count() > 0)
                        <div>
                            @foreach($card->categories as $category)
                            <span class="badge modal-category-badge">{{ $category->name }}</span>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    <!-- Boutons d'action visibles pour le propriétaire et les administrateurs -->
                    @if(Auth::check() && (Auth::id() === $card->user_id || Auth::user()->role === 'admin'))
                    <div class="mt-3 text-end">
                        @if(Auth::id() === $card->user_id)
                        <a href="{{ route('cards_edit', $card->id) }}" class="btn btn-sm btn-primary">Modifier</a>
                        @endif
                        <form action="{{ route('cards_delete', $card->id) }}" method="POST" class="inline-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer cette carte ?')">Supprimer</button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>