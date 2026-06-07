<?php

namespace App\Exports;

use App\Models\Stagiaire;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AbsencesParStagiaireExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $groupe_id;

    public function __construct($groupe_id = null)
    {
        $this->groupe_id = $groupe_id;
    }

    public function collection()
    {
        if ($this->groupe_id) {
            return Stagiaire::where('groupe_id', $this->groupe_id)->with('groupe')->get();
        }
        return Stagiaire::with('groupe')->get();
    }

    public function headings(): array
    {
        return [
            'Matricule',
            'Nom',
            'Prénom',
            'CIN',
            'Groupe',
            'Heures Absence',
            'Taux Absence (%)',
            'Retards',
            'Statut',
        ];
    }

    public function map($stagiaire): array
    {
        return [
            $stagiaire->matricule,
            $stagiaire->nom,
            $stagiaire->prenom,
            $stagiaire->cin,
            $stagiaire->groupe->nom ?? '',
            $stagiaire->total_heures_absence,
            $stagiaire->pourcentage_absence . '%',
            $stagiaire->total_retards,
            ucfirst($stagiaire->statut),
        ];
    }
}
