@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold">Tableau de bord Formateur</h2>
            <p class="text-muted">Aujourd'hui : {{ \Carbon\Carbon::now()->translatedFormat('l j F Y') }}</p>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card h-100 border-start border-primary border-4">
                <div class="card-body">
                    <h6 class="text-muted text-uppercase mb-2">Séances prévues aujourd'hui</h6>
                    <h2 class="fw-bold mb-0 text-primary">{{ $seances_today->count() }} <span class="fs-5 text-muted fw-normal">séance(s)</span></h2>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card h-100 border-start border-success border-4">
                <div class="card-body">
                    <h6 class="text-muted text-uppercase mb-2">Total Séances à venir</h6>
                    <h2 class="fw-bold mb-0 text-success">{{ $seances_a_venir }} <span class="fs-5 text-muted fw-normal">séance(s)</span></h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0"><i class="fa-solid fa-calendar-day text-primary me-2"></i> Mon planning du jour</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Horaire</th>
                                    <th>Groupe</th>
                                    <th>Module</th>
                                    <th>Salle</th>
                                    <th>Statut</th>
                                    <th class="text-end pe-4">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($seances_today as $seance)
                                <tr>
                                    <td class="ps-4 fw-medium">
                                        {{ \Carbon\Carbon::parse($seance->heure_debut)->format('H:i') }} - 
                                        {{ \Carbon\Carbon::parse($seance->heure_fin)->format('H:i') }}
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $seance->groupe->nom }}</span>
                                    </td>
                                    <td>{{ $seance->module }}</td>
                                    <td>{{ $seance->salle }}</td>
                                    <td>
                                        @if($seance->statut == 'planifiee')
                                            <span class="badge bg-warning text-dark"><i class="fa-solid fa-clock me-1"></i> À venir</span>
                                        @else
                                            <span class="badge bg-success"><i class="fa-solid fa-check me-1"></i> Terminée</span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        @if($seance->statut == 'planifiee')
                                            <a href="{{ route('formateur.presences.create', $seance->id) }}" class="btn btn-sm btn-primary">Faire l'appel</a>
                                        @else
                                            <a href="{{ route('formateur.seances.show', $seance->id) }}" class="btn btn-sm btn-outline-secondary">Voir</a>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        <i class="fa-solid fa-mug-hot fs-1 mb-3 d-block text-black-50"></i>
                                        Aucune séance prévue pour aujourd'hui.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
