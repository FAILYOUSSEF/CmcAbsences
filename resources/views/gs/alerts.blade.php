@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h2 class="fw-bold">Alertes</h2>
        <p class="text-muted">Stagiaires ayant dépassé les seuils d'absence ou de retard</p>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Type</th>
                            <th>Stagiaire</th>
                            <th>Groupe</th>
                            <th>Message</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($alerts as $alert)
                        <tr class="{{ $alert->is_read ? '' : 'table-warning' }}">
                            <td class="ps-4">
                                @if($alert->type == 'absence')
                                    <span class="badge bg-danger"><i class="fa-solid fa-circle-exclamation me-1"></i>Absence</span>
                                @else
                                    <span class="badge bg-warning text-dark"><i class="fa-solid fa-clock me-1"></i>Retard</span>
                                @endif
                            </td>
                            <td class="fw-bold">{{ $alert->stagiaire->nom }} {{ $alert->stagiaire->prenom }}</td>
                            <td><span class="badge bg-secondary">{{ $alert->stagiaire->groupe->nom }}</span></td>
                            <td class="text-muted">{{ $alert->message }}</td>
                            <td class="text-muted">{{ $alert->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-check-circle fs-1 mb-3 d-block text-success"></i>
                                Aucune alerte pour le moment. Tout est en ordre !
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($alerts->hasPages())
        <div class="card-footer bg-white pt-3 pb-2">{{ $alerts->links() }}</div>
        @endif
    </div>
</div>
@endsection
