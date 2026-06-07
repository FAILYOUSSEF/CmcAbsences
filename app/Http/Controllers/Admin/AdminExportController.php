<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pole;
use App\Models\Groupe;
use Illuminate\Http\Request;

class AdminExportController extends Controller
{
    public function index()
    {
        $poles = Pole::all();
        $groupes = Groupe::all();
        return view('admin.exports.index', compact('poles', 'groupes'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'type' => 'required|in:absences_groupe,absences_stagiaire,absences_pole,retards',
            'format' => 'required|in:excel,pdf',
        ]);

        $type = $request->type;
        $format = $request->format;

        if ($format === 'excel') {
            switch ($type) {
                case 'absences_groupe':
                    return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\AbsencesParGroupeExport($request->groupe_id), 'absences_groupe.xlsx');
                case 'absences_stagiaire':
                    return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\AbsencesParStagiaireExport($request->groupe_id), 'absences_stagiaire.xlsx');
                case 'absences_pole':
                    return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\AbsencesParPoleExport($request->pole_id), 'absences_pole.xlsx');
                case 'retards':
                    return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\RetardsExport($request->groupe_id), 'retards.xlsx');
            }
        } else {
            // PDF
            $data = $this->getExportData($type, $request);
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('exports.pdf.' . $type, $data);
            return $pdf->download($type . '.pdf');
        }
    }

    private function getExportData(string $type, Request $request): array
    {
        switch ($type) {
            case 'absences_groupe':
                $groupe = Groupe::with('stagiaires.presences')->find($request->groupe_id);
                return ['groupe' => $groupe, 'title' => 'Absences par Groupe: ' . ($groupe->nom ?? 'Tous')];
            case 'absences_pole':
                $pole = Pole::with('groupes.stagiaires.presences')->find($request->pole_id);
                return ['pole' => $pole, 'title' => 'Absences du Pôle: ' . ($pole->nom ?? 'Tous')];
            case 'retards':
                $groupe = Groupe::with('stagiaires.presences')->find($request->groupe_id);
                return ['groupe' => $groupe, 'title' => 'Retards du Groupe: ' . ($groupe->nom ?? 'Tous')];
            default:
                return ['title' => 'Export'];
        }
    }
}
