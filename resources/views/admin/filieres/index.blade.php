@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">Gestion des Filières</h2>
            <p class="text-muted">Gérez les filières de l'établissement</p>
        </div>
        <a href="{{ route('admin.filieres.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus me-2"></i>Nouvelle Filière</a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Nom de la Filière</th>
                            <th>Pôle</th>
                            <th class="text-center">Groupes</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($filieres as $filiere)
                        <tr>
                            <td class="ps-4 fw-bold">{{ $filiere->nom }}</td>
                            <td><span class="badge bg-secondary">{{ $filiere->pole->nom }}</span></td>
                            <td class="text-center"><span class="badge bg-light text-dark rounded-pill">{{ $filiere->groupes_count }}</span></td>
                            <td class="text-end pe-4">
                                <a href="{{ route('admin.filieres.edit', $filiere->id) }}" class="btn btn-sm btn-light text-warning"><i class="fa-solid fa-pen"></i></a>
                                <form action="{{ route('admin.filieres.destroy', $filiere->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr ?');">
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
        <div class="card-footer bg-white border-top-0 pt-3">
            {{ $filieres->links() }}
        </div>
    </div>
</div>
@endsection
