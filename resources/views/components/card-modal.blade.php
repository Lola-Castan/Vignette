@props(['card', 'modalId'])

<div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-labelledby="{{ $modalId }}Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: var(--card-bg); color: var(--text-color)">
            <div class="modal-header" style="background-color: var(--navbar-bg); color: var(--navbar-text)">
                <h5 class="modal-title" id="{{ $modalId }}Label">{{ $card->title ?? $card->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body text-center">
                @if($card->music && $card->image)
                <div style="position: relative; width: 100%; display: flex; justify-content: center; align-items: center; flex-direction: column; gap: 10px;">
                    <img src="{{ asset($card->image) }}" class="img-fluid mb-5 card-modal-media-image" alt="{{ $card->title ?? $card->name }}">
                    <audio controls preload="auto" style="height: 40px; width:100%; position: absolute; bottom: 0; left: 0; background: rgba(255,255,255,0.7);">
                        <source src="{{ asset($card->music) }}">
                        Votre navigateur ne supporte pas l'élément audio.
                    </audio>
                </div>
                @elseif($card->image)
                <img src="{{ asset($card->image) }}" class="img-fluid mb-3 card-modal-media-image" alt="{{ $card->title ?? $card->name }}">
                @elseif($card->music)
                <audio controls preload="auto" class="mb-3">
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
                            <span class="badge" style="background-color: var(--button-primary-bg); color: var(--button-primary-text)">{{ $category->name }}</span>
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
                        <form action="{{ route('cards_delete', $card->id) }}" method="POST" style="display:inline-block;">
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