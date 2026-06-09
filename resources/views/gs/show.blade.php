@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Back Button & Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('gs.stagiaires') }}" class="btn btn-sm btn-outline-secondary mb-2">
                <i class="fa-solid fa-arrow-left me-2"></i>Retour aux stagiaires
            </a>
            <h2 class="fw-bold mb-0">Fiche Stagiaire</h2>
            <p class="text-muted">Profil et historique d'absences détaillé</p>
        </div>
        <div>
            <span class="badge bg-{{ $stagiaire->statut == 'actif' ? 'success' : 'danger' }} px-3 py-2 fs-6">
                {{ ucfirst($stagiaire->statut) }}
            </span>
        </div>
    </div>

    <div class="row g-4">
        <!-- Profile Card (Left Column) -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body text-center pt-5 pb-4">
                    <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <span class="fw-bold fs-2">{{ substr($stagiaire->prenom, 0, 1) }}{{ substr($stagiaire->nom, 0, 1) }}</span>
                    </div>
                    <h4 class="fw-bold mb-1">{{ $stagiaire->nom }} {{ $stagiaire->prenom }}</h4>
                    <p class="text-muted small mb-3">Matricule: <span class="fw-medium text-dark">{{ $stagiaire->matricule }}</span></p>

                    <div class="border-top pt-3 text-start">
                        <div class="mb-2">
                            <label class="text-muted small d-block">CIN</label>
                            <span class="fw-medium">{{ $stagiaire->cin ?? 'N/A' }}</span>
                        </div>
                        <div class="mb-2">
                            <label class="text-muted small d-block">Groupe</label>
                            <span class="badge bg-secondary">{{ $stagiaire->groupe->nom }}</span>
                        </div>
                        <div class="mb-2">
                            <label class="text-muted small d-block">Filière</label>
                            <span class="fw-medium text-wrap-break">{{ $stagiaire->groupe->filiere->nom ?? 'N/A' }}</span>
                        </div>
                        <div class="mb-2">
                            <label class="text-muted small d-block font-sans-serif">Email</label>
                            <a href="mailto:{{ $stagiaire->email }}" class="text-decoration-none text-primary">{{ $stagiaire->email ?? 'Non renseigné' }}</a>
                        </div>
                        <div class="mb-0">
                            <label class="text-muted small d-block">Téléphone</label>
                            <span class="fw-medium">{{ $stagiaire->telephone ?? 'Non renseigné' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Disciplinary Alerts / Notifications Card -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0 text-dark"><i class="fa-solid fa-bell text-warning me-2"></i>Avertissements & Alertes</h5>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush border-top">
                        @forelse($stagiaire->alerts as $alert)
                            <li class="list-group-item py-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="badge bg-{{ $alert->type == 'danger' || $alert->type == 'exclusion' ? 'danger' : 'warning text-dark' }}">{{ ucfirst($alert->type) }}</span>
                                    <span class="text-muted small">{{ $alert->created_at->format('d/m/Y') }}</span>
                                </div>
                                <p class="mb-0 small text-muted">{{ $alert->message }}</p>
                            </li>
                        @empty
                            <li class="list-group-item py-4 text-center text-muted">
                                <i class="fa-solid fa-circle-check fs-3 mb-2 d-block text-success"></i>
                                Aucun avertissement à ce jour.
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        <!-- Attendance Stats & History (Right Column) -->
        <div class="col-lg-8">
            <!-- Stats Counters -->
            <div class="row g-3 mb-4">
                <div class="col-sm-4">
                    <div class="card shadow-sm border-0 bg-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted small text-uppercase mb-1 fw-bold">Absences Cumulées</h6>
                                    <h3 class="mb-0 fw-bold @if($stagiaire->total_heures_absence >= 20) text-danger @elseif($stagiaire->total_heures_absence >= 10) text-warning @else text-dark @endif">
                                        {{ $stagiaire->total_heures_absence }}h
                                    </h3>
                                </div>
                                <div class="rounded-circle bg-danger bg-opacity-10 text-danger p-3">
                                    <i class="fa-solid fa-user-xmark fs-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card shadow-sm border-0 bg-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted small text-uppercase mb-1 fw-bold">Retards Signalés</h6>
                                    <h3 class="mb-0 fw-bold text-dark">
                                        {{ $stagiaire->total_retards }}
                                    </h3>
                                    @if($stagiaire->total_minutes_retard > 0)
                                        <small class="text-muted">Total: {{ $stagiaire->total_minutes_retard }} min</small>
                                    @endif
                                </div>
                                <div class="rounded-circle bg-warning bg-opacity-10 text-warning p-3">
                                    <i class="fa-solid fa-clock-rotate-left fs-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card shadow-sm border-0 bg-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted small text-uppercase mb-1 fw-bold">Taux d'Absence</h6>
                                    <h3 class="mb-0 fw-bold text-dark">
                                        {{ $stagiaire->pourcentage_absence }}%
                                    </h3>
                                </div>
                                <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-3">
                                    <i class="fa-solid fa-percent fs-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Absences History List -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-dark">Historique Complet des Absences & Retards</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Date & Heures</th>
                                    <th>Module / Matière</th>
                                    <th>Formateur</th>
                                    <th>Statut</th>
                                    <th class="text-end pe-4">Détails</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($history as $presence)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-bold">{{ Carbon\Carbon::parse($presence->seance->date)->format('d/m/Y') }}</div>
                                            <div class="text-muted small">{{ Carbon\Carbon::parse($presence->seance->heure_debut)->format('H:i') }} - {{ Carbon\Carbon::parse($presence->seance->heure_fin)->format('H:i') }}</div>
                                        </td>
                                        <td class="fw-medium text-dark">{{ $presence->seance->module }}</td>
                                        <td>
                                            <div class="small">
                                                <i class="fa-solid fa-user-tie text-muted me-1"></i>
                                                {{ $presence->seance->formateur->nom }} {{ $presence->seance->formateur->prenom }}
                                            </div>
                                        </td>
                                        <td>
                                            @if($presence->statut === 'absent')
                                                <span class="badge bg-danger">Absent</span>
                                            @elseif($presence->statut === 'retard')
                                                <span class="badge bg-warning text-dark">Retard</span>
                                            @else
                                                <span class="badge bg-success">Présent</span>
                                            @endif
                                        </td>
                                        <td class="text-end pe-4 font-monospace">
                                            @if($presence->statut === 'absent')
                                                <span class="text-danger fw-bold">-{{ $presence->heures_absence }}h</span>
                                            @elseif($presence->statut === 'retard')
                                                <span class="text-warning fw-bold">{{ $presence->minutes_retard }} min</span>
                                            @else
                                                <span class="text-success fw-bold">OK</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-muted">
                                            <i class="fa-solid fa-circle-check fs-1 mb-3 d-block text-success"></i>
                                            Aucune absence ou retard répertorié. Excellent assiduité !
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($history->hasPages())
                    <div class="card-footer bg-white pt-3 pb-2">
                        {{ $history->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
