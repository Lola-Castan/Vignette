@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <span>Gestion des cartes</span>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if($cards->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Titre</th>
                                        <th>Contenu</th>
                                        <th>Créateur</th>
                                        <th>Taille</th>
                                        <th>Catégories</th>
                                        <th>Date de création</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cards as $card)
                                        <tr>
                                            <td>{{ $card->title }}</td>
                                            <td>{{ Str::limit($card->content, 50) }}</td>
                                            <td>{{ $card->user->name }}</td>
                                            <td>{{ $card->cardSize->name }} ({{ $card->cardSize->width }}x{{ $card->cardSize->height }})</td>
                                            <td>
                                                @foreach($card->categories as $category)
                                                    <span class="badge bg-primary">{{ $category->name }}</span>
                                                @endforeach
                                            </td>
                                            <td>{{ $card->created_at->format('d/m/Y') }}</td>
                                            <td class="d-flex">
                                                <a href="{{ route('admin.cards.edit', $card) }}" class="btn btn-sm btn-info me-2">
                                                    <i class="fas fa-edit"></i> Modifier taille
                                                </a>
                                                
                                                <form action="{{ route('admin.cards.destroy', $card) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette carte ?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash"></i> Supprimer
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            Aucune carte n'a été créée pour le moment.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection