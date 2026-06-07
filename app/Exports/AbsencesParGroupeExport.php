<?php

namespace App\Exports;

use App\Models\Groupe;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AbsencesParGroupeExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $groupe_id;

    public function __construct($groupe_id = null)
    {
        $this->groupe_id = $groupe_id;
    }

    public function collection()
    {
        if ($this->groupe_id) {
            $groupe = Groupe::with('stagiaires')->find($this->groupe_id);
            return $groupe ? collect([$groupe]) : collect([]);
        }
        return Groupe::with('stagiaires')->get();
    }

    public function headings(): array
    {
        return [
            'Groupe',
            'Filière',
            'Pôle',
            'Nombre Stagiaires',
            'Total Heures Absence',
            'Moyenne Absence par Stagiaire',
        ];
    }

    public function map($groupe): array
    {
        $total_absences = $groupe->stagiaires->sum('total_heures_absence');
        $stagiaires_count = $groupe->stagiaires->count();
        $moyenne = $stagiaires_count > 0 ? round($total_absences / $stagiaires_count, 1) : 0;

        return [
            $groupe->nom,
            $groupe->filiere->nom ?? '',
            $groupe->pole->nom ?? '',
            $stagiaires_count,
            $total_absences,
            $moyenne,
        ];
    }
}
