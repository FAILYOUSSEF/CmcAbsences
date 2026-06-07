@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h2 class="fw-bold">Centre d'Exports</h2>
        <p class="text-muted">Générez des rapports Excel ou PDF</p>
    </div>

    <div class="row g-4">
        <div class="col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-success text-white pt-4 pb-3">
                    <h5 class="fw-bold mb-0"><i class="fa-solid fa-file-excel me-2"></i>Export Excel</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.exports.generate') }}" method="POST">
                        @csrf
                        <input type="hidden" name="format" value="excel">

                        <div class="mb-3">
                            <label for="type_excel" class="form-label fw-bold">Type de Rapport</label>
                            <select class="form-select" id="type_excel" name="type" required>
                                <option value="absences_groupe">Absences par Groupe</option>
                                <option value="absences_stagiaire">Absences par Stagiaire</option>
                                <option value="absences_pole">Absences par Pôle</option>
                                <option value="retards">Retards</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="pole_id_excel" class="form-label fw-bold">Pôle (optionnel)</label>
                            <select class="form-select" id="pole_id_excel" name="pole_id">
                                <option value="">-- Tous les pôles --</option>
                                @foreach($poles as $pole)
                                    <option value="{{ $pole->id }}">{{ $pole->nom }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="groupe_id_excel" class="form-label fw-bold">Groupe (optionnel)</label>
                            <select class="form-select" id="groupe_id_excel" name="groupe_id">
                                <option value="">-- Tous les groupes --</option>
                                @foreach($groupes as $groupe)
                                    <option value="{{ $groupe->id }}">{{ $groupe->nom }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success w-100"><i class="fa-solid fa-download me-2"></i>Télécharger Excel</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-danger text-white pt-4 pb-3">
                    <h5 class="fw-bold mb-0"><i class="fa-solid fa-file-pdf me-2"></i>Export PDF</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.exports.generate') }}" method="POST">
                        @csrf
                        <input type="hidden" name="format" value="pdf">

                        <div class="mb-3">
                            <label for="type_pdf" class="form-label fw-bold">Type de Rapport</label>
                            <select class="form-select" id="type_pdf" name="type" required>
                                <option value="absences_groupe">Absences par Groupe</option>
                                <option value="absences_pole">Absences par Pôle</option>
                                <option value="retards">Retards</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="pole_id_pdf" class="form-label fw-bold">Pôle (optionnel)</label>
                            <select class="form-select" id="pole_id_pdf" name="pole_id">
                                <option value="">-- Tous les pôles --</option>
                                @foreach($poles as $pole)
                                    <option value="{{ $pole->id }}">{{ $pole->nom }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="groupe_id_pdf" class="form-label fw-bold">Groupe (optionnel)</label>
                            <select class="form-select" id="groupe_id_pdf" name="groupe_id">
                                <option value="">-- Tous les groupes --</option>
                                @foreach($groupes as $groupe)
                                    <option value="{{ $groupe->id }}">{{ $groupe->nom }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-danger w-100"><i class="fa-solid fa-download me-2"></i>Télécharger PDF</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
