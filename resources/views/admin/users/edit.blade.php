@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Modifier l'utilisateur: {{ $user->name }}</span>
                    <a href="{{ route('admin.users.list') }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left"></i> Retour à la liste
                    </a>
                </div>

                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.users.update', $user) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Nom</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Adresse email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Nouveau mot de passe (laisser vide pour conserver l'actuel)</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirmer le nouveau mot de passe</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                        </div>

                        <!-- Le champ rôle est remplacé par un affichage statique -->
                        <div class="mb-3">
                            <label class="form-label">Rôle</label>
                            <div class="form-control bg-light">{{ $user->role === 'admin' ? 'Administrateur' : 'Utilisateur' }}</div>
                            <div class="form-text text-muted">
                                {{ $user->role === 'admin' ? 'Le rôle administrateur est unique et ne peut pas être modifié.' : 'Les rôles ne peuvent pas être modifiés.' }}
                            </div>
                            <!-- Maintenir le rôle actuel -->
                            <input type="hidden" name="role" value="{{ $user->role }}">
                        </div>

                        <div class="mb-3">
                            <label for="magic_number" class="form-label">Nombre magique (optionnel)</label>
                            <input type="number" class="form-control @error('magic_number') is-invalid @enderror" id="magic_number" name="magic_number" value="{{ old('magic_number', $user->magic_number) }}">
                            @error('magic_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Mettre à jour
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection