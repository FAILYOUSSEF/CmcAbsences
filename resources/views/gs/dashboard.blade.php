@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold">Tableau de bord GS</h2>
            <p class="text-muted">Gestion des absences de votre pôle — {{ auth()->user()->gestionnaireStag->pole->nom ?? '' }}</p>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card h-100 bg-primary text-white">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="card-title text-uppercase mb-1" style="opacity: 0.8">Mes Groupes</h6>
                        <h2 class="fw-bold mb-0">{{ $stats['groupes_count'] }}</h2>
                    </div>
                    <div class="fs-1" style="opacity: 0.5"><i class="fa-solid fa-users"></i></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 bg-info text-white">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="card-title text-uppercase mb-1" style="opacity: 0.8">Stagiaires</h6>
                        <h2 class="fw-bold mb-0">{{ $stats['stagiaires_count'] }}</h2>
                    </div>
                    <div class="fs-1" style="opacity: 0.5"><i class="fa-solid fa-user-graduate"></i></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 bg-danger text-white">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="card-title text-uppercase mb-1" style="opacity: 0.8">Alertes Non Lues</h6>
                        <h2 class="fw-bold mb-0">{{ $stats['alerts_count'] }}</h2>
                    </div>
                    <div class="fs-1" style="opacity: 0.5"><i class="fa-solid fa-bell"></i></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-7">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white pt-4 pb-3 border-bottom-0">
                    <h5 class="fw-bold mb-0"><i class="fa-solid fa-ranking-star text-danger me-2"></i>Top 5 Stagiaires — Plus Absents</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">#</th>
                                    <th>Stagiaire</th>
                                    <th>Groupe</th>
                                    <th class="text-center">Heures</th>
                                    <th class="text-center">Retards</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($top_absents as $i => $s)
                                <tr>
                                    <td class="ps-4 fw-bold text-muted">{{ $i + 1 }}</td>
                                    <td class="fw-bold">{{ $s->nom }} {{ $s->prenom }}</td>
                                    <td><span class="badge bg-secondary">{{ $s->groupe->nom }}</span></td>
                                    <td class="text-center">
                                        <span class="badge bg-{{ $s->total_heures_absence >= 20 ? 'danger' : ($s->total_heures_absence >= 10 ? 'warning text-dark' : 'light text-dark') }} fs-6">{{ $s->total_heures_absence }}h</span>
                                    </td>
                                    <td class="text-center">{{ $s->total_retards }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white pt-4 pb-3 border-bottom-0">
                    <h5 class="fw-bold mb-0">Actions Rapides</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-3">
                        <a href="{{ route('gs.groupes') }}" class="btn btn-outline-primary text-start"><i class="fa-solid fa-users me-2"></i>Voir mes groupes</a>
                        <a href="{{ route('gs.stagiaires') }}" class="btn btn-outline-primary text-start"><i class="fa-solid fa-user-graduate me-2"></i>Liste des stagiaires</a>
                        <a href="{{ route('gs.statistiques') }}" class="btn btn-outline-info text-start"><i class="fa-solid fa-chart-bar me-2"></i>Statistiques</a>
                        <a href="{{ route('gs.alerts') }}" class="btn btn-outline-danger text-start"><i class="fa-solid fa-bell me-2"></i>Alertes ({{ $stats['alerts_count'] }})</a>
                        <a href="{{ route('gs.exports.index') }}" class="btn btn-outline-success text-start"><i class="fa-solid fa-file-excel me-2"></i>Exporter des données</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
