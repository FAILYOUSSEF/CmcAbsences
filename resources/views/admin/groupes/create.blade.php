@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('admin.groupes.index') }}" class="btn btn-light mb-3"><i class="fa-solid fa-arrow-left me-2"></i>Retour</a>
            <h2 class="fw-bold">{{ isset($groupe) ? 'Modifier le Groupe' : 'Nouveau Groupe' }}</h2>
        </div>
    </div>

    <div class="card shadow-sm border-0" style="max-width: 600px;">
        <div class="card-body">
            <form action="{{ isset($groupe) ? route('admin.groupes.update', $groupe->id) : route('admin.groupes.store') }}" method="POST">
                @csrf
                @if(isset($groupe)) @method('PUT') @endif

                <div class="mb-3">
                    <label for="nom" class="form-label fw-bold">Nom du Groupe</label>
                    <input type="text" class="form-control @error('nom') is-invalid @enderror" id="nom" name="nom" value="{{ old('nom', $groupe->nom ?? '') }}" required placeholder="Ex: DEV101">
                    @error('nom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label for="annee_formation" class="form-label fw-bold">Année de Formation</label>
                    <input type="number" class="form-control @error('annee_formation') is-invalid @enderror" id="annee_formation" name="annee_formation" value="{{ old('annee_formation', $groupe->annee_formation ?? date('Y')) }}" required>
                    @error('annee_formation')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label for="pole_id" class="form-label fw-bold">Pôle</label>
                    <select class="form-select @error('pole_id') is-invalid @enderror" id="pole_id" name="pole_id" required>
                        <option value="">-- Sélectionner un pôle --</option>
                        @foreach($poles as $pole)
                            <option value="{{ $pole->id }}" {{ old('pole_id', $groupe->pole_id ?? '') == $pole->id ? 'selected' : '' }}>{{ $pole->nom }}</option>
                        @endforeach
                    </select>
                    @error('pole_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-4">
                    <label for="filiere_id" class="form-label fw-bold">Filière</label>
                    <select class="form-select @error('filiere_id') is-invalid @enderror" id="filiere_id" name="filiere_id" required>
                        <option value="">-- Sélectionner une filière --</option>
                        @foreach($filieres as $filiere)
                            <option value="{{ $filiere->id }}" {{ old('filiere_id', $groupe->filiere_id ?? '') == $filiere->id ? 'selected' : '' }}>{{ $filiere->nom }}</option>
                        @endforeach
                    </select>
                    @error('filiere_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save me-2"></i>Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
