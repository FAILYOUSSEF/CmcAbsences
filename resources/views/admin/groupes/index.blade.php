@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">Gestion des Groupes</h2>
            <p class="text-muted">Gérez les groupes de formation</p>
        </div>
        <a href="{{ route('admin.groupes.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus me-2"></i>Nouveau Groupe</a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Nom du Groupe</th>
                            <th>Filière</th>
                            <th>Pôle</th>
                            <th class="text-center">Année</th>
                            <th class="text-center">Stagiaires</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($groupes as $groupe)
                        <tr>
                            <td class="ps-4 fw-bold">{{ $groupe->nom }}</td>
                            <td>{{ $groupe->filiere->nom }}</td>
                            <td><span class="badge bg-primary bg-opacity-75">{{ $groupe->pole->nom }}</span></td>
                            <td class="text-center">{{ $groupe->annee_formation }}</td>
                            <td class="text-center"><span class="badge bg-info rounded-pill">{{ $groupe->stagiaires_count }}</span></td>
                            <td class="text-end pe-4">
                                <a href="{{ route('admin.groupes.show', $groupe->id) }}" class="btn btn-sm btn-light text-primary"><i class="fa-solid fa-eye"></i></a>
                                <a href="{{ route('admin.groupes.edit', $groupe->id) }}" class="btn btn-sm btn-light text-warning"><i class="fa-solid fa-pen"></i></a>
                                <form action="{{ route('admin.groupes.destroy', $groupe->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light text-danger"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-top-0 pt-3">{{ $groupes->links() }}</div>
    </div>
</div>
@endsection
