@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h2 class="fw-bold">Statistiques</h2>
        <p class="text-muted">Vue d'ensemble des absences et retards par groupe</p>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white pt-4 pb-3 border-bottom-0">
                    <h5 class="fw-bold mb-0"><i class="fa-solid fa-chart-bar text-primary me-2"></i>Absences par Groupe (Heures)</h5>
                </div>
                <div class="card-body">
                    <canvas id="absencesChart" height="120"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white pt-4 pb-3 border-bottom-0">
                    <h5 class="fw-bold mb-0"><i class="fa-solid fa-chart-pie text-warning me-2"></i>Retards par Groupe</h5>
                </div>
                <div class="card-body">
                    <canvas id="retardsChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white pt-4 pb-3 border-bottom-0">
            <h5 class="fw-bold mb-0">Détail par Groupe</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Groupe</th>
                            <th class="text-center">Nb Stagiaires</th>
                            <th class="text-center">Total Heures Abs.</th>
                            <th class="text-center">Total Retards</th>
                            <th class="text-center">Moy. Abs./Stag.</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($groupeStats as $gs)
                        <tr>
                            <td class="ps-4 fw-bold">{{ $gs['nom'] }}</td>
                            <td class="text-center">{{ $gs['stagiaires'] }}</td>
                            <td class="text-center">
                                <span class="badge bg-{{ $gs['total_absences'] > 50 ? 'danger' : ($gs['total_absences'] > 20 ? 'warning text-dark' : 'success') }} fs-6">{{ $gs['total_absences'] }}h</span>
                            </td>
                            <td class="text-center">{{ $gs['total_retards'] }}</td>
                            <td class="text-center">{{ $gs['stagiaires'] > 0 ? round($gs['total_absences'] / $gs['stagiaires'], 1) : 0 }}h</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const labels = @json($groupeStats->pluck('nom'));
    const absData = @json($groupeStats->pluck('total_absences'));
    const retData = @json($groupeStats->pluck('total_retards'));

    new Chart(document.getElementById('absencesChart'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Heures d\'absence',
                data: absData,
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                borderRadius: 6
            }]
        },
        options: { scales: { y: { beginAtZero: true } }, plugins: { legend: { display: false } } }
    });

    new Chart(document.getElementById('retardsChart'), {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: retData,
                backgroundColor: ['#ff6384', '#36a2eb', '#ffce56', '#4bc0c0', '#9966ff', '#ff9f40', '#c9cbcf'],
                borderWidth: 2
            }]
        },
        options: { plugins: { legend: { position: 'bottom' } } }
    });
</script>
@endsection
