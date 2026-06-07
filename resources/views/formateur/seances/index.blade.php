@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">Mes Séances</h2>
            <p class="text-muted">Gérez vos séances de formation et faites l'appel</p>
        </div>
        <a href="{{ route('formateur.seances.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus me-2"></i>Nouvelle Séance</a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Date</th>
                            <th>Horaire</th>
                            <th>Module</th>
                            <th>Groupe</th>
                            <th>Salle</th>
                            <th>Statut</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($seances as $seance)
                        <tr>
                            <td class="ps-4 fw-medium">{{ \Carbon\Carbon::parse($seance->date)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($seance->heure_debut)->format('H:i') }} - {{ \Carbon\Carbon::parse($seance->heure_fin)->format('H:i') }}</td>
                            <td class="fw-bold">{{ $seance->module }}</td>
                            <td><span class="badge bg-secondary">{{ $seance->groupe->nom }}</span></td>
                            <td>{{ $seance->salle }}</td>
                            <td>
                                @if($seance->statut == 'planifiee')
                                    <span class="badge bg-warning text-dark"><i class="fa-solid fa-clock me-1"></i>À faire</span>
                                @else
                                    <span class="badge bg-success"><i class="fa-solid fa-check-circle me-1"></i>Appel fait</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                @if($seance->statut == 'planifiee')
                                    <a href="{{ route('formateur.presences.create', $seance->id) }}" class="btn btn-sm btn-success"><i class="fa-solid fa-clipboard-user me-1"></i>Faire l'appel</a>
                                @else
                                    <a href="{{ route('formateur.seances.show', $seance->id) }}" class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-eye me-1"></i>Voir l'appel</a>
                                @endif
                                <a href="{{ route('formateur.seances.edit', $seance->id) }}" class="btn btn-sm btn-light text-warning ms-1"><i class="fa-solid fa-pen"></i></a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Vous n'avez aucune séance programmée.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($seances->hasPages())
        <div class="card-footer bg-white border-top-0 pt-3">{{ $seances->links() }}</div>
        @endif
    </div>
</div>
@endsection
