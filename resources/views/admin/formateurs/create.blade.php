@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('admin.formateurs.index') }}" class="btn btn-light mb-3"><i class="fa-solid fa-arrow-left me-2"></i>Retour</a>
            <h2 class="fw-bold">{{ isset($formateur) ? 'Modifier le Formateur' : 'Nouveau Formateur' }}</h2>
        </div>
    </div>

    <div class="card shadow-sm border-0" style="max-width: 600px;">
        <div class="card-body">
            <form action="{{ isset($formateur) ? route('admin.formateurs.update', $formateur->id) : route('admin.formateurs.store') }}" method="POST">
                @csrf
                @if(isset($formateur)) @method('PUT') @endif

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="prenom" class="form-label fw-bold">Prénom</label>
                        <input type="text" class="form-control @error('prenom') is-invalid @enderror" id="prenom" name="prenom" value="{{ old('prenom', $formateur->prenom ?? '') }}" required>
                        @error('prenom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="nom" class="form-label fw-bold">Nom</label>
                        <input type="text" class="form-control @error('nom') is-invalid @enderror" id="nom" name="nom" value="{{ old('nom', $formateur->nom ?? '') }}" required>
                        @error('nom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label fw-bold">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $formateur->email ?? '') }}" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label for="telephone" class="form-label fw-bold">Téléphone</label>
                    <input type="text" class="form-control @error('telephone') is-invalid @enderror" id="telephone" name="telephone" value="{{ old('telephone', $formateur->telephone ?? '') }}">
                    @error('telephone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label for="specialite" class="form-label fw-bold">Spécialité</label>
                    <input type="text" class="form-control @error('specialite') is-invalid @enderror" id="specialite" name="specialite" value="{{ old('specialite', $formateur->specialite ?? '') }}">
                    @error('specialite')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-4">
                    <label for="pole_id" class="form-label fw-bold">Pôle</label>
                    <select class="form-select @error('pole_id') is-invalid @enderror" id="pole_id" name="pole_id" required>
                        <option value="">-- Sélectionner un pôle --</option>
                        @foreach($poles as $pole)
                            <option value="{{ $pole->id }}" {{ old('pole_id', $formateur->pole_id ?? '') == $pole->id ? 'selected' : '' }}>{{ $pole->nom }}</option>
                        @endforeach
                    </select>
                    @error('pole_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                @unless(isset($formateur))
                <div class="alert alert-info border-0">
                    <i class="fa-solid fa-info-circle me-2"></i> Le mot de passe par défaut sera: <strong>password</strong>
                </div>
                @endunless

                <div class="text-end">
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save me-2"></i>Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
