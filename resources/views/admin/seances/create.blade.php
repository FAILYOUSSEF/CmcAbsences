@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <a href="{{ route('admin.seances.index') }}" class="btn btn-light mb-3"><i class="fa-solid fa-arrow-left me-2"></i>Retour</a>
        <h2 class="fw-bold">{{ isset($seance) ? 'Modifier la Séance' : 'Nouvelle Séance' }}</h2>
    </div>

    <div class="card shadow-sm border-0" style="max-width: 700px;">
        <div class="card-body">
            <form action="{{ isset($seance) ? route('admin.seances.update', $seance->id) : route('admin.seances.store') }}" method="POST">
                @csrf
                @if(isset($seance)) @method('PUT') @endif

                <div class="mb-3">
                    <label for="date" class="form-label fw-bold">Date</label>
                    <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date" value="{{ old('date', isset($seance) ? $seance->date : date('Y-m-d')) }}" required>
                    @error('date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="heure_debut" class="form-label fw-bold">Heure de Début</label>
                        <input type="time" class="form-control @error('heure_debut') is-invalid @enderror" id="heure_debut" name="heure_debut" value="{{ old('heure_debut', $seance->heure_debut ?? '08:30') }}" required>
                        @error('heure_debut')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="heure_fin" class="form-label fw-bold">Heure de Fin</label>
                        <input type="time" class="form-control @error('heure_fin') is-invalid @enderror" id="heure_fin" name="heure_fin" value="{{ old('heure_fin', $seance->heure_fin ?? '11:00') }}" required>
                        @error('heure_fin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="module" class="form-label fw-bold">Module</label>
                    <input type="text" class="form-control @error('module') is-invalid @enderror" id="module" name="module" value="{{ old('module', $seance->module ?? '') }}" required placeholder="Ex: Programmation Web">
                    @error('module')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label for="salle" class="form-label fw-bold">Salle</label>
                    <input type="text" class="form-control @error('salle') is-invalid @enderror" id="salle" name="salle" value="{{ old('salle', $seance->salle ?? '') }}" required placeholder="Ex: Salle A1">
                    @error('salle')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="groupe_id" class="form-label fw-bold">Groupe</label>
                        <select class="form-select @error('groupe_id') is-invalid @enderror" id="groupe_id" name="groupe_id" required>
                            <option value="">-- Sélectionner --</option>
                            @foreach($groupes as $groupe)
                                <option value="{{ $groupe->id }}" {{ old('groupe_id', $seance->groupe_id ?? '') == $groupe->id ? 'selected' : '' }}>{{ $groupe->nom }}</option>
                            @endforeach
                        </select>
                        @error('groupe_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="formateur_id" class="form-label fw-bold">Formateur</label>
                        <select class="form-select @error('formateur_id') is-invalid @enderror" id="formateur_id" name="formateur_id" required>
                            <option value="">-- Sélectionner --</option>
                            @foreach($formateurs as $formateur)
                                <option value="{{ $formateur->id }}" {{ old('formateur_id', $seance->formateur_id ?? '') == $formateur->id ? 'selected' : '' }}>{{ $formateur->prenom }} {{ $formateur->nom }}</option>
                            @endforeach
                        </select>
                        @error('formateur_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
