@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <a href="{{ route('formateur.seances.index') }}" class="btn btn-light mb-3"><i class="fa-solid fa-arrow-left me-2"></i>Retour</a>
        <h2 class="fw-bold">{{ isset($seance) ? 'Modifier la Séance' : 'Nouvelle Séance' }}</h2>
    </div>

    <div class="card shadow-sm border-0" style="max-width: 600px;">
        <div class="card-body">
            <form action="{{ isset($seance) ? route('formateur.seances.update', $seance->id) : route('formateur.seances.store') }}" method="POST">
                @csrf
                @if(isset($seance)) @method('PUT') @endif

                <div class="mb-3">
                    <label class="form-label fw-bold">Date</label>
                    <input type="date" class="form-control" name="date" value="{{ old('date', $seance->date ?? date('Y-m-d')) }}" required>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Heure de Début</label>
                        <input type="time" class="form-control" name="heure_debut" value="{{ old('heure_debut', $seance->heure_debut ?? '08:30') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Heure de Fin</label>
                        <input type="time" class="form-control" name="heure_fin" value="{{ old('heure_fin', $seance->heure_fin ?? '11:00') }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Module / Matière</label>
                    <input type="text" class="form-control" name="module" value="{{ old('module', $seance->module ?? '') }}" required placeholder="Ex: Développement Front-End">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Salle</label>
                    <input type="text" class="form-control" name="salle" value="{{ old('salle', $seance->salle ?? '') }}" required placeholder="Ex: Salle A1">
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Groupe</label>
                    <select class="form-select" name="groupe_id" required>
                        <option value="">-- Choisir un groupe --</option>
                        @foreach($groupes as $groupe)
                            <option value="{{ $groupe->id }}" {{ old('groupe_id', $seance->groupe_id ?? '') == $groupe->id ? 'selected' : '' }}>{{ $groupe->nom }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save me-2"></i>Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
