@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <a href="{{ route('admin.seances.index') }}" class="btn btn-light mb-3"><i class="fa-solid fa-arrow-left me-2"></i>Retour</a>
        <h2 class="fw-bold">Détails de la Séance</h2>
        <p class="text-muted">
            {{ \Carbon\Carbon::parse($seance->date)->format('d/m/Y') }} — 
            {{ \Carbon\Carbon::parse($seance->heure_debut)->format('H:i') }} à {{ \Carbon\Carbon::parse($seance->heure_fin)->format('H:i') }} |
            {{ $seance->module }} | {{ $seance->groupe->nom }} | {{ $seance->formateur->prenom }} {{ $seance->formateur->nom }}
        </p>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white pt-4 pb-3 border-bottom-0">
            <h5 class="fw-bold mb-0">Feuille de Présence</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Stagiaire</th>
                            <th class="text-center">Statut</th>
                            <th class="text-center">Minutes Retard</th>
                            <th class="text-center">Heures Absence</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($seance->presences as $presence)
                        <tr>
                            <td class="ps-4 fw-bold">{{ $presence->stagiaire->nom }} {{ $presence->stagiaire->prenom }}</td>
                            <td class="text-center">
                                @if($presence->statut == 'present')
                                    <span class="badge bg-success">Présent</span>
                                @elseif($presence->statut == 'absent')
                                    <span class="badge bg-danger">Absent</span>
                                @else
                                    <span class="badge bg-warning text-dark">Retard</span>
                                @endif
                            </td>
                            <td class="text-center">{{ $presence->minutes_retard ?? '—' }}</td>
                            <td class="text-center">{{ $presence->heures_absence ?? 0 }}h</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">L'appel n'a pas encore été fait pour cette séance.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
