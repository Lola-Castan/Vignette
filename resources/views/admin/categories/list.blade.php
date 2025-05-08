@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Gestion des catégories</span>
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Nouvelle catégorie
                    </a>
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

                    @if($categories->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Statut</th>
                                        <th>Nombre de cartes</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categories as $category)
                                        <tr>
                                            <td>{{ $category->name }}</td>
                                            <td>
                                                @if($category->enabled)
                                                    <span class="badge bg-success">Activé</span>
                                                @else
                                                    <span class="badge bg-danger">Désactivé</span>
                                                @endif
                                            </td>
                                            <td>{{ $category->cards->count() }}</td>
                                            <td class="d-flex">
                                                <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-info me-2">
                                                    <i class="fas fa-edit"></i> Modifier
                                                </a>
                                                
                                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" {{ $category->cards->count() > 0 ? 'disabled' : '' }}>
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
                            Aucune catégorie n'a été créée pour le moment.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection