@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <a href="{{ route('formateur.seances.index') }}" class="btn btn-light mb-3"><i class="fa-solid fa-arrow-left me-2"></i>Retour</a>
        <h2 class="fw-bold">Récapitulatif de l'Appel</h2>
        <p class="text-muted">
            Séance du {{ \Carbon\Carbon::parse($seance->date)->format('d/m/Y') }} 
            ( {{ \Carbon\Carbon::parse($seance->heure_debut)->format('H:i') }} - {{ \Carbon\Carbon::parse($seance->heure_fin)->format('H:i') }} )
            | {{ $seance->module }} | Groupe: {{ $seance->groupe->nom }}
        </p>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-start border-success border-4">
                <div class="card-body">
                    <h6 class="text-muted text-uppercase mb-1">Présents</h6>
                    <h2 class="fw-bold text-success mb-0">{{ $seance->presences->where('statut', 'present')->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-start border-danger border-4">
                <div class="card-body">
                    <h6 class="text-muted text-uppercase mb-1">Absents</h6>
                    <h2 class="fw-bold text-danger mb-0">{{ $seance->presences->where('statut', 'absent')->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-start border-warning border-4">
                <div class="card-body">
                    <h6 class="text-muted text-uppercase mb-1">En Retard</h6>
                    <h2 class="fw-bold text-warning mb-0">{{ $seance->presences->where('statut', 'retard')->count() }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white pt-4 pb-3 border-bottom-0">
            <h5 class="fw-bold mb-0">Détails de présence</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Stagiaire</th>
                            <th class="text-center">Statut</th>
                            <th class="text-center">Détail (Retard)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($seance->presences as $presence)
                        <tr>
                            <td class="ps-4 fw-bold">{{ $presence->stagiaire->nom }} {{ $presence->stagiaire->prenom }}</td>
                            <td class="text-center">
                                @if($presence->statut == 'present')
                                    <span class="badge bg-success">Présent</span>
                                @elseif($presence->statut == 'absent')
                                    <span class="badge bg-danger">Absent</span>
                                @else
                                    <span class="badge bg-warning text-dark">Retard</span>
                                @endif
                            </td>
                            <td class="text-center text-muted">
                                @if($presence->statut == 'retard')
                                    {{ $presence->minutes_retard }} min
                                @else
                                    —
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
