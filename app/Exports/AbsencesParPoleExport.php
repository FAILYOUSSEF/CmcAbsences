<?php

namespace App\Exports;

use App\Models\Pole;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AbsencesParPoleExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $pole_id;

    public function __construct($pole_id = null)
    {
        $this->pole_id = $pole_id;
    }

    public function collection()
    {
        if ($this->pole_id) {
            return Pole::where('id', $this->pole_id)->with('groupes.stagiaires')->get();
        }
        return Pole::with('groupes.stagiaires')->get();
    }

    public function headings(): array
    {
        return [
            'Pôle',
            'Nombre Groupes',
            'Nombre Stagiaires',
            'Total Heures Absence',
            'Total Retards',
        ];
    }

    public function map($pole): array
    {
        $total_absences = 0;
        $total_retards = 0;
        $stagiaires_count = 0;
        
        foreach ($pole->groupes as $groupe) {
            $stagiaires_count += $groupe->stagiaires->count();
            foreach ($groupe->stagiaires as $stagiaire) {
                $total_absences += $stagiaire->total_heures_absence;
                $total_retards += $stagiaire->total_retards;
            }
        }

        return [
            $pole->nom,
            $pole->groupes->count(),
            $stagiaires_count,
            $total_absences,
            $total_retards,
        ];
    }
}
