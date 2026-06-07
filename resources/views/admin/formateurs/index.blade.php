@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">Gestion des Formateurs</h2>
            <p class="text-muted">Gérez les formateurs de l'établissement</p>
        </div>
        <a href="{{ route('admin.formateurs.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus me-2"></i>Nouveau Formateur</a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Formateur</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Spécialité</th>
                            <th>Pôle</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($formateurs as $formateur)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-warning bg-opacity-10 text-warning d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                        <span class="fw-bold">{{ substr($formateur->prenom, 0, 1) }}{{ substr($formateur->nom, 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <div class="fw-bold">{{ $formateur->prenom }} {{ $formateur->nom }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $formateur->email }}</td>
                            <td>{{ $formateur->telephone ?? '—' }}</td>
                            <td>{{ $formateur->specialite ?? '—' }}</td>
                            <td><span class="badge bg-primary bg-opacity-75">{{ $formateur->pole->nom }}</span></td>
                            <td class="text-end pe-4">
                                <a href="{{ route('admin.formateurs.edit', $formateur->id) }}" class="btn btn-sm btn-light text-warning"><i class="fa-solid fa-pen"></i></a>
                                <form action="{{ route('admin.formateurs.destroy', $formateur->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr ?');">
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
        <div class="card-footer bg-white border-top-0 pt-3">{{ $formateurs->links() }}</div>
    </div>
</div>
@endsection
