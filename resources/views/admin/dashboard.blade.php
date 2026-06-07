@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold">Tableau de bord Administrateur</h2>
            <p class="text-muted">Aperçu général de l'établissement</p>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card h-100 bg-primary text-white">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="card-title text-uppercase mb-1" style="opacity: 0.8">Pôles</h6>
                        <h2 class="fw-bold mb-0">{{ $stats['poles'] }}</h2>
                    </div>
                    <div class="fs-1" style="opacity: 0.5">
                        <i class="fa-solid fa-building"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100 bg-success text-white">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="card-title text-uppercase mb-1" style="opacity: 0.8">Groupes</h6>
                        <h2 class="fw-bold mb-0">{{ $stats['groupes'] }}</h2>
                    </div>
                    <div class="fs-1" style="opacity: 0.5">
                        <i class="fa-solid fa-users"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100 bg-warning text-dark">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="card-title text-uppercase mb-1" style="opacity: 0.8">Formateurs</h6>
                        <h2 class="fw-bold mb-0">{{ $stats['formateurs'] }}</h2>
                    </div>
                    <div class="fs-1" style="opacity: 0.5">
                        <i class="fa-solid fa-chalkboard-user"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100 bg-info text-white">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="card-title text-uppercase mb-1" style="opacity: 0.8">Stagiaires</h6>
                        <h2 class="fw-bold mb-0">{{ $stats['stagiaires'] }}</h2>
                    </div>
                    <div class="fs-1" style="opacity: 0.5">
                        <i class="fa-solid fa-user-graduate"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                    <h5 class="fw-bold">Statistiques globales</h5>
                </div>
                <div class="card-body">
                    <canvas id="myChart" height="100"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                    <h5 class="fw-bold">Actions rapides</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-3">
                        <a href="{{ route('admin.stagiaires.index') }}" class="btn btn-outline-primary text-start"><i class="fa-solid fa-plus me-2"></i> Ajouter un stagiaire</a>
                        <a href="{{ route('admin.formateurs.index') }}" class="btn btn-outline-primary text-start"><i class="fa-solid fa-plus me-2"></i> Ajouter un formateur</a>
                        <a href="{{ route('admin.groupes.index') }}" class="btn btn-outline-primary text-start"><i class="fa-solid fa-plus me-2"></i> Créer un groupe</a>
                        <a href="{{ route('admin.exports.index') }}" class="btn btn-outline-success text-start"><i class="fa-solid fa-file-excel me-2"></i> Exporter des données</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const ctx = document.getElementById('myChart');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($labelsMois ?? ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin']),
            datasets: [{
                label: 'Absences (Heures)',
                data: @json($absencesParMois ?? [120, 190, 150, 170, 140, 90]),
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                borderRadius: 4
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection
