<?php

namespace App\Exports;

use App\Models\Stagiaire;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class RetardsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $groupe_id;

    public function __construct($groupe_id = null)
    {
        $this->groupe_id = $groupe_id;
    }

    public function collection()
    {
        $query = Stagiaire::with('groupe');
        if ($this->groupe_id) {
            $query->where('groupe_id', $this->groupe_id);
        }
        
        // On ne retourne que les stagiaires qui ont des retards
        return $query->get()->filter(function ($stagiaire) {
            return $stagiaire->total_retards > 0;
        });
    }

    public function headings(): array
    {
        return [
            'Matricule',
            'Nom Complet',
            'Groupe',
            'Nombre Total de Retards',
            'En Alerte (>= 5)',
        ];
    }

    public function map($stagiaire): array
    {
        return [
            $stagiaire->matricule,
            $stagiaire->nom . ' ' . $stagiaire->prenom,
            $stagiaire->groupe->nom ?? '',
            $stagiaire->total_retards,
            $stagiaire->total_retards >= 5 ? 'Oui' : 'Non',
        ];
    }
}
