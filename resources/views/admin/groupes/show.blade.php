@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('admin.groupes.index') }}" class="btn btn-light mb-3"><i class="fa-solid fa-arrow-left me-2"></i>Retour</a>
            <h2 class="fw-bold">{{ $groupe->nom }}</h2>
            <p class="text-muted">{{ $groupe->filiere->nom }} — {{ $groupe->pole->nom }}</p>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-start border-primary border-4">
                <div class="card-body">
                    <h6 class="text-muted text-uppercase">Nombre de Stagiaires</h6>
                    <h2 class="fw-bold text-primary">{{ $groupe->stagiaires->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-start border-success border-4">
                <div class="card-body">
                    <h6 class="text-muted text-uppercase">Année de Formation</h6>
                    <h2 class="fw-bold text-success">{{ $groupe->annee_formation }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white pt-4 pb-3 border-bottom-0">
            <h5 class="fw-bold mb-0">Liste des Stagiaires du Groupe</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Matricule</th>
                            <th>Nom Complet</th>
                            <th>CIN</th>
                            <th class="text-center">Absences (h)</th>
                            <th class="text-center">Retards</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($groupe->stagiaires as $stagiaire)
                        <tr>
                            <td class="ps-4 fw-medium text-muted">{{ $stagiaire->matricule }}</td>
                            <td class="fw-bold">{{ $stagiaire->nom }} {{ $stagiaire->prenom }}</td>
                            <td>{{ $stagiaire->cin }}</td>
                            <td class="text-center">
                                @if($stagiaire->total_heures_absence >= 20)
                                    <span class="badge bg-danger fs-6">{{ $stagiaire->total_heures_absence }}h</span>
                                @else
                                    <span>{{ $stagiaire->total_heures_absence }}h</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($stagiaire->total_retards >= 5)
                                    <span class="badge bg-warning text-dark fs-6">{{ $stagiaire->total_retards }}</span>
                                @else
                                    {{ $stagiaire->total_retards }}
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-{{ $stagiaire->statut == 'actif' ? 'success' : 'danger' }}">{{ ucfirst($stagiaire->statut) }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Aucun stagiaire dans ce groupe.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
