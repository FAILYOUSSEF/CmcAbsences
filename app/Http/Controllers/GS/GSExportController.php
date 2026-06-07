<?php

namespace App\Http\Controllers\GS;

use App\Http\Controllers\Controller;
use App\Models\Groupe;
use Illuminate\Http\Request;

class GSExportController extends Controller
{
    public function index()
    {
        $pole_id = auth()->user()->gestionnaireStag->pole_id;
        $groupes = Groupe::where('pole_id', $pole_id)->get();
        return view('gs.exports', compact('groupes'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'type' => 'required|in:absences_groupe,absences_stagiaire,retards',
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
                case 'retards':
                    return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\RetardsExport($request->groupe_id), 'retards.xlsx');
            }
        } else {
            $groupe = Groupe::with('stagiaires.presences')->find($request->groupe_id);
            $data = ['groupe' => $groupe, 'title' => 'Rapport — ' . ($groupe->nom ?? 'Tous')];
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('exports.pdf.' . $type, $data);
            return $pdf->download($type . '.pdf');
        }
    }
}
