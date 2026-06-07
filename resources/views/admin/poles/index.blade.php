@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">Gestion des Pôles</h2>
            <p class="text-muted">Gérez les pôles de formation de l'établissement</p>
        </div>
        <a href="{{ route('admin.poles.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus me-2"></i>Nouveau Pôle</a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Nom du Pôle</th>
                            <th>Description</th>
                            <th class="text-center">Filières</th>
                            <th class="text-center">Groupes</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($poles as $pole)
                        <tr>
                            <td class="ps-4 fw-bold">{{ $pole->nom }}</td>
                            <td class="text-muted">{{ Str::limit($pole->description, 50) }}</td>
                            <td class="text-center"><span class="badge bg-secondary rounded-pill">{{ $pole->filieres_count }}</span></td>
                            <td class="text-center"><span class="badge bg-secondary rounded-pill">{{ $pole->groupes_count }}</span></td>
                            <td class="text-end pe-4">
                                <a href="{{ route('admin.poles.edit', $pole->id) }}" class="btn btn-sm btn-light text-warning"><i class="fa-solid fa-pen"></i></a>
                                <form action="{{ route('admin.poles.destroy', $pole->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr ?');">
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
            {{ $poles->links() }}
        </div>
    </div>
</div>
@endsection
