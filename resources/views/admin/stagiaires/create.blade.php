@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('admin.stagiaires.index') }}" class="btn btn-light mb-3"><i class="fa-solid fa-arrow-left me-2"></i>Retour</a>
            <h2 class="fw-bold">{{ isset($stagiaire) ? 'Modifier le Stagiaire' : 'Nouveau Stagiaire' }}</h2>
        </div>
    </div>

    <div class="card shadow-sm border-0" style="max-width: 700px;">
        <div class="card-body">
            <form action="{{ isset($stagiaire) ? route('admin.stagiaires.update', $stagiaire->id) : route('admin.stagiaires.store') }}" method="POST">
                @csrf
                @if(isset($stagiaire)) @method('PUT') @endif

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="matricule" class="form-label fw-bold">Matricule</label>
                        <input type="text" class="form-control @error('matricule') is-invalid @enderror" id="matricule" name="matricule" value="{{ old('matricule', $stagiaire->matricule ?? '') }}" required>
                        @error('matricule')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="cin" class="form-label fw-bold">CIN</label>
                        <input type="text" class="form-control @error('cin') is-invalid @enderror" id="cin" name="cin" value="{{ old('cin', $stagiaire->cin ?? '') }}" required>
                        @error('cin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="nom" class="form-label fw-bold">Nom</label>
                        <input type="text" class="form-control @error('nom') is-invalid @enderror" id="nom" name="nom" value="{{ old('nom', $stagiaire->nom ?? '') }}" required>
                        @error('nom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="prenom" class="form-label fw-bold">Prénom</label>
                        <input type="text" class="form-control @error('prenom') is-invalid @enderror" id="prenom" name="prenom" value="{{ old('prenom', $stagiaire->prenom ?? '') }}" required>
                        @error('prenom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="email" class="form-label fw-bold">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $stagiaire->email ?? '') }}">
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="telephone" class="form-label fw-bold">Téléphone</label>
                        <input type="text" class="form-control @error('telephone') is-invalid @enderror" id="telephone" name="telephone" value="{{ old('telephone', $stagiaire->telephone ?? '') }}">
                        @error('telephone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="groupe_id" class="form-label fw-bold">Groupe</label>
                        <select class="form-select @error('groupe_id') is-invalid @enderror" id="groupe_id" name="groupe_id" required>
                            <option value="">-- Sélectionner un groupe --</option>
                            @foreach($groupes as $groupe)
                                <option value="{{ $groupe->id }}" {{ old('groupe_id', $stagiaire->groupe_id ?? '') == $groupe->id ? 'selected' : '' }}>{{ $groupe->nom }}</option>
                            @endforeach
                        </select>
                        @error('groupe_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="statut" class="form-label fw-bold">Statut</label>
                        <select class="form-select @error('statut') is-invalid @enderror" id="statut" name="statut" required>
                            <option value="actif" {{ old('statut', $stagiaire->statut ?? 'actif') == 'actif' ? 'selected' : '' }}>Actif</option>
                            <option value="inactif" {{ old('statut', $stagiaire->statut ?? '') == 'inactif' ? 'selected' : '' }}>Inactif</option>
                        </select>
                        @error('statut')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save me-2"></i>Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
