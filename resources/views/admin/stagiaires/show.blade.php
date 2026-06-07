@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <a href="{{ route('admin.stagiaires.index') }}" class="btn btn-light mb-3"><i class="fa-solid fa-arrow-left me-2"></i>Retour</a>
        <h2 class="fw-bold">{{ $stagiaire->prenom }} {{ $stagiaire->nom }}</h2>
        <p class="text-muted">Matricule: {{ $stagiaire->matricule }} | CIN: {{ $stagiaire->cin }} | Groupe: {{ $stagiaire->groupe->nom }}</p>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-start border-danger border-4">
                <div class="card-body text-center">
                    <h6 class="text-muted text-uppercase">Heures d'Absence</h6>
                    <h2 class="fw-bold text-danger">{{ $stagiaire->total_heures_absence }}h</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-start border-warning border-4">
                <div class="card-body text-center">
                    <h6 class="text-muted text-uppercase">Retards</h6>
                    <h2 class="fw-bold text-warning">{{ $stagiaire->total_retards }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-start border-info border-4">
                <div class="card-body text-center">
                    <h6 class="text-muted text-uppercase">Taux Absence</h6>
                    <h2 class="fw-bold text-info">{{ $stagiaire->pourcentage_absence }}%</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-start border-{{ $stagiaire->statut == 'actif' ? 'success' : 'danger' }} border-4">
                <div class="card-body text-center">
                    <h6 class="text-muted text-uppercase">Statut</h6>
                    <h2 class="fw-bold text-{{ $stagiaire->statut == 'actif' ? 'success' : 'danger' }}">{{ ucfirst($stagiaire->statut) }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white pt-4 pb-3 border-bottom-0">
            <h5 class="fw-bold mb-0">Historique des Présences</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Date</th>
                            <th>Horaire</th>
                            <th>Module</th>
                            <th>Statut</th>
                            <th>Détail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stagiaire->presences->sortByDesc('created_at') as $presence)
                        <tr>
                            <td class="ps-4">{{ \Carbon\Carbon::parse($presence->seance->date)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($presence->seance->heure_debut)->format('H:i') }} - {{ \Carbon\Carbon::parse($presence->seance->heure_fin)->format('H:i') }}</td>
                            <td>{{ $presence->seance->module }}</td>
                            <td>
                                @if($presence->statut == 'present')
                                    <span class="badge bg-success">Présent</span>
                                @elseif($presence->statut == 'absent')
                                    <span class="badge bg-danger">Absent</span>
                                @else
                                    <span class="badge bg-warning text-dark">Retard</span>
                                @endif
                            </td>
                            <td>
                                @if($presence->statut == 'absent')
                                    {{ $presence->heures_absence }}h d'absence
                                @elseif($presence->statut == 'retard')
                                    {{ $presence->minutes_retard }} min de retard
                                @else
                                    —
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Aucun historique de présence.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
