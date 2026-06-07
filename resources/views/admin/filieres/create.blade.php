@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('admin.filieres.index') }}" class="btn btn-light mb-3"><i class="fa-solid fa-arrow-left me-2"></i>Retour</a>
            <h2 class="fw-bold">{{ isset($filiere) ? 'Modifier la Filière' : 'Nouvelle Filière' }}</h2>
        </div>
    </div>

    <div class="card shadow-sm border-0" style="max-width: 600px;">
        <div class="card-body">
            <form action="{{ isset($filiere) ? route('admin.filieres.update', $filiere->id) : route('admin.filieres.store') }}" method="POST">
                @csrf
                @if(isset($filiere))
                    @method('PUT')
                @endif

                <div class="mb-3">
                    <label for="nom" class="form-label fw-bold">Nom de la Filière</label>
                    <input type="text" class="form-control @error('nom') is-invalid @enderror" id="nom" name="nom" value="{{ old('nom', $filiere->nom ?? '') }}" required>
                    @error('nom')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="pole_id" class="form-label fw-bold">Pôle</label>
                    <select class="form-select @error('pole_id') is-invalid @enderror" id="pole_id" name="pole_id" required>
                        <option value="">-- Sélectionner un pôle --</option>
                        @foreach($poles as $pole)
                            <option value="{{ $pole->id }}" {{ old('pole_id', $filiere->pole_id ?? '') == $pole->id ? 'selected' : '' }}>{{ $pole->nom }}</option>
                        @endforeach
                    </select>
                    @error('pole_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save me-2"></i>Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
