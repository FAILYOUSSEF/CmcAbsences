@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h2 class="fw-bold">Mes Groupes</h2>
        <p class="text-muted">Les groupes de votre pôle</p>
    </div>

    <div class="row g-4">
        @forelse($groupes as $groupe)
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h5 class="fw-bold mb-0">{{ $groupe->nom }}</h5>
                        <span class="badge bg-primary rounded-pill">{{ $groupe->stagiaires_count }} stagiaires</span>
                    </div>
                    <p class="text-muted mb-1"><i class="fa-solid fa-graduation-cap me-2"></i>{{ $groupe->filiere->nom }}</p>
                    <p class="text-muted mb-3"><i class="fa-solid fa-calendar me-2"></i>Année: {{ $groupe->annee_formation }}</p>
                    <a href="{{ route('gs.stagiaires', ['groupe_id' => $groupe->id]) }}" class="btn btn-sm btn-outline-primary">
                        <i class="fa-solid fa-eye me-1"></i>Voir les stagiaires
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info">Aucun groupe dans votre pôle.</div>
        </div>
        @endforelse
    </div>

    <div class="mt-4">{{ $groupes->links() }}</div>
</div>
@endsection
