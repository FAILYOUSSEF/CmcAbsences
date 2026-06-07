@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">Gestion des Séances</h2>
            <p class="text-muted">Planifiez et gérez les séances de formation</p>
        </div>
        <a href="{{ route('admin.seances.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus me-2"></i>Nouvelle Séance</a>
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
                            <th>Formateur</th>
                            <th>Salle</th>
                            <th>Statut</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($seances as $seance)
                        <tr>
                            <td class="ps-4 fw-medium">{{ \Carbon\Carbon::parse($seance->date)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($seance->heure_debut)->format('H:i') }} - {{ \Carbon\Carbon::parse($seance->heure_fin)->format('H:i') }}</td>
                            <td>{{ $seance->module }}</td>
                            <td><span class="badge bg-secondary">{{ $seance->groupe->nom }}</span></td>
                            <td>{{ $seance->formateur->prenom }} {{ $seance->formateur->nom }}</td>
                            <td>{{ $seance->salle }}</td>
                            <td>
                                @if($seance->statut == 'planifiee')
                                    <span class="badge bg-warning text-dark"><i class="fa-solid fa-clock me-1"></i>Planifiée</span>
                                @else
                                    <span class="badge bg-success"><i class="fa-solid fa-check me-1"></i>Terminée</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('admin.seances.show', $seance->id) }}" class="btn btn-sm btn-light text-primary"><i class="fa-solid fa-eye"></i></a>
                                <a href="{{ route('admin.seances.edit', $seance->id) }}" class="btn btn-sm btn-light text-warning"><i class="fa-solid fa-pen"></i></a>
                                <form action="{{ route('admin.seances.destroy', $seance->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr ?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light text-danger"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-top-0 pt-3">{{ $seances->links() }}</div>
    </div>
</div>
@endsection
