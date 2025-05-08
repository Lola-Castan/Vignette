@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Créer une nouvelle catégorie</span>
                    <a href="{{ route('admin.categories.list') }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left"></i> Retour à la liste
                    </a>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.categories.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Nom de la catégorie</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="enabled" name="enabled" value="1" {{ old('enabled', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="enabled">Activer cette catégorie</label>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection