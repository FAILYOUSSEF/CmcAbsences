@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('formateur.dashboard') }}" class="btn btn-light mb-3"><i class="fa-solid fa-arrow-left me-2"></i>Retour</a>
            <h2 class="fw-bold">Feuille de Présence</h2>
            <p class="text-muted">
                Séance du {{ \Carbon\Carbon::parse($seance->date)->format('d/m/Y') }} 
                de {{ \Carbon\Carbon::parse($seance->heure_debut)->format('H:i') }} 
                à {{ \Carbon\Carbon::parse($seance->heure_fin)->format('H:i') }}
            </p>
        </div>
        <div class="text-end">
            <h5 class="fw-bold text-primary">{{ $seance->groupe->nom }}</h5>
            <span class="badge bg-secondary">{{ $seance->module }}</span>
            <span class="badge bg-light text-dark"><i class="fa-solid fa-door-open me-1"></i> {{ $seance->salle }}</span>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-bottom-0 pt-4 pb-3">
            <h5 class="fw-bold mb-0">Liste des stagiaires</h5>
        </div>
        <div class="card-body p-0">
            <form action="{{ route('formateur.presences.store', $seance->id) }}" method="POST">
                @csrf
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Stagiaire</th>
                                <th class="text-center" style="width: 150px;">Présent</th>
                                <th class="text-center" style="width: 150px;">Absent</th>
                                <th class="text-center" style="width: 250px;">En Retard (Minutes)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($stagiaires as $stagiaire)
                                @php
                                    $presence = $presences->get($stagiaire->id);
                                    $statut = $presence ? $presence->statut : 'present';
                                    $retard = $presence ? $presence->minutes_retard : '';
                                @endphp
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold">{{ $stagiaire->nom }} {{ $stagiaire->prenom }}</div>
                                        <div class="text-muted small">{{ $stagiaire->matricule }}</div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" 
                                                name="presences[{{ $stagiaire->id }}][statut]" 
                                                id="present_{{ $stagiaire->id }}" 
                                                value="present" 
                                                {{ $statut == 'present' ? 'checked' : '' }}
                                                onchange="toggleRetardInput({{ $stagiaire->id }}, false)">
                                            <label class="form-check-label text-success fw-medium" for="present_{{ $stagiaire->id }}">
                                                <i class="fa-solid fa-check"></i>
                                            </label>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" 
                                                name="presences[{{ $stagiaire->id }}][statut]" 
                                                id="absent_{{ $stagiaire->id }}" 
                                                value="absent" 
                                                {{ $statut == 'absent' ? 'checked' : '' }}
                                                onchange="toggleRetardInput({{ $stagiaire->id }}, false)">
                                            <label class="form-check-label text-danger fw-medium" for="absent_{{ $stagiaire->id }}">
                                                <i class="fa-solid fa-xmark"></i>
                                            </label>
                                        </div>
                                    </td>
                                    <td class="text-center d-flex justify-content-center align-items-center gap-2">
                                        <div class="form-check form-check-inline m-0">
                                            <input class="form-check-input" type="radio" 
                                                name="presences[{{ $stagiaire->id }}][statut]" 
                                                id="retard_{{ $stagiaire->id }}" 
                                                value="retard" 
                                                {{ $statut == 'retard' ? 'checked' : '' }}
                                                onchange="toggleRetardInput({{ $stagiaire->id }}, true)">
                                            <label class="form-check-label text-warning text-dark fw-medium" for="retard_{{ $stagiaire->id }}">
                                                <i class="fa-solid fa-clock"></i>
                                            </label>
                                        </div>
                                        <input type="number" 
                                            class="form-control form-control-sm" 
                                            name="presences[{{ $stagiaire->id }}][minutes_retard]" 
                                            id="minutes_{{ $stagiaire->id }}" 
                                            value="{{ $retard }}"
                                            placeholder="Min"
                                            style="width: 70px; {{ $statut == 'retard' ? '' : 'display: none;' }}">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-light p-3 text-end border-top-0 rounded-bottom">
                    <button type="submit" class="btn btn-primary px-4 fw-bold">Enregistrer l'appel</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function toggleRetardInput(id, show) {
        const input = document.getElementById('minutes_' + id);
        if (show) {
            input.style.display = 'block';
            input.required = true;
        } else {
            input.style.display = 'none';
            input.required = false;
        }
    }
</script>
@endsection
