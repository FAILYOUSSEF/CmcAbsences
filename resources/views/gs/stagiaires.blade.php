@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">Stagiaires</h2>
            <p class="text-muted">Liste des stagiaires de votre pôle</p>
        </div>
    </div>

    <!-- Filtres -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('gs.stagiaires') }}" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Rechercher</label>
                    <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Nom, prénom, matricule, CIN...">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Groupe</label>
                    <select class="form-select" name="groupe_id">
                        <option value="">Tous les groupes</option>
                        @foreach($groupes as $g)
                            <option value="{{ $g->id }}" {{ request('groupe_id') == $g->id ? 'selected' : '' }}>{{ $g->nom }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100"><i class="fa-solid fa-search me-2"></i>Filtrer</button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('gs.stagiaires') }}" class="btn btn-outline-secondary w-100">Réinitialiser</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Matricule</th>
                            <th>Stagiaire</th>
                            <th>Groupe</th>
                            <th>Statut</th>
                            <th class="text-center">Absences (h)</th>
                            <th class="text-center">Retards</th>
                            <th class="text-center">Taux (%)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stagiaires as $stagiaire)
                        <tr>
                            <td class="ps-4 fw-medium text-muted">{{ $stagiaire->matricule }}</td>
                            <td>
                                <a href="{{ route('gs.stagiaires.show', $stagiaire->id) }}" class="text-decoration-none text-dark d-flex align-items-center">
                                    <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                        <span class="fw-bold">{{ substr($stagiaire->prenom, 0, 1) }}{{ substr($stagiaire->nom, 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-primary">{{ $stagiaire->nom }} {{ $stagiaire->prenom }}</div>
                                        <div class="text-muted small">{{ $stagiaire->cin }}</div>
                                    </div>
                                </a>
                            </td>
                            <td><span class="badge bg-secondary">{{ $stagiaire->groupe->nom }}</span></td>
                            <td><span class="badge bg-{{ $stagiaire->statut == 'actif' ? 'success' : 'danger' }}">{{ ucfirst($stagiaire->statut) }}</span></td>
                            <td class="text-center">
                                @if($stagiaire->total_heures_absence >= 20)
                                    <span class="badge bg-danger fs-6">{{ $stagiaire->total_heures_absence }}h</span>
                                @elseif($stagiaire->total_heures_absence >= 10)
                                    <span class="badge bg-warning text-dark fs-6">{{ $stagiaire->total_heures_absence }}h</span>
                                @else
                                    <span class="fw-medium">{{ $stagiaire->total_heures_absence }}h</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($stagiaire->total_retards >= 5)
                                    <span class="badge bg-warning text-dark">{{ $stagiaire->total_retards }}</span>
                                @else
                                    {{ $stagiaire->total_retards }}
                                @endif
                            </td>
                            <td class="text-center fw-medium">{{ $stagiaire->pourcentage_absence }}%</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-users fs-1 mb-3 d-block text-black-50"></i>
                                Aucun stagiaire trouvé.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($stagiaires->hasPages())
        <div class="card-footer bg-white pt-3 pb-2">{{ $stagiaires->links() }}</div>
        @endif
    </div>
</div>
@endsection
