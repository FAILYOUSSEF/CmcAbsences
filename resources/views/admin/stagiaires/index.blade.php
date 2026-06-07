@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">Gestion des Stagiaires</h2>
            <p class="text-muted">Gérez les stagiaires de l'établissement</p>
        </div>
        <a href="{{ route('admin.stagiaires.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus me-2"></i>Nouveau Stagiaire</a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Matricule</th>
                            <th>Stagiaire</th>
                            <th>CIN</th>
                            <th>Groupe</th>
                            <th>Statut</th>
                            <th class="text-center">Absences (h)</th>
                            <th class="text-center">Retards</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($stagiaires as $stagiaire)
                        <tr>
                            <td class="ps-4 fw-medium text-muted">{{ $stagiaire->matricule }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-info bg-opacity-10 text-info d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                        <span class="fw-bold">{{ substr($stagiaire->prenom, 0, 1) }}{{ substr($stagiaire->nom, 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <div class="fw-bold">{{ $stagiaire->nom }} {{ $stagiaire->prenom }}</div>
                                        <div class="text-muted small">{{ $stagiaire->email ?? '—' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $stagiaire->cin }}</td>
                            <td><span class="badge bg-secondary">{{ $stagiaire->groupe->nom }}</span></td>
                            <td><span class="badge bg-{{ $stagiaire->statut == 'actif' ? 'success' : 'danger' }}">{{ ucfirst($stagiaire->statut) }}</span></td>
                            <td class="text-center">
                                @if($stagiaire->total_heures_absence >= 20)
                                    <span class="badge bg-danger fs-6">{{ $stagiaire->total_heures_absence }}h</span>
                                @elseif($stagiaire->total_heures_absence >= 10)
                                    <span class="badge bg-warning text-dark fs-6">{{ $stagiaire->total_heures_absence }}h</span>
                                @else
                                    {{ $stagiaire->total_heures_absence }}h
                                @endif
                            </td>
                            <td class="text-center">
                                @if($stagiaire->total_retards >= 5)
                                    <span class="badge bg-warning text-dark">{{ $stagiaire->total_retards }}</span>
                                @else
                                    {{ $stagiaire->total_retards }}
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('admin.stagiaires.show', $stagiaire->id) }}" class="btn btn-sm btn-light text-primary"><i class="fa-solid fa-eye"></i></a>
                                <a href="{{ route('admin.stagiaires.edit', $stagiaire->id) }}" class="btn btn-sm btn-light text-warning"><i class="fa-solid fa-pen"></i></a>
                                <form action="{{ route('admin.stagiaires.destroy', $stagiaire->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr ?');">
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
        <div class="card-footer bg-white border-top-0 pt-3">{{ $stagiaires->links() }}</div>
    </div>
</div>
@endsection
