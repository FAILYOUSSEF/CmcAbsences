<?php

namespace App\Http\Controllers\Formateur;

use App\Http\Controllers\Controller;
use App\Models\Seance;
use Illuminate\Http\Request;
use Carbon\Carbon;

class FormateurDashboardController extends Controller
{
    public function index()
    {
        $formateur_id = auth()->user()->formateur->id;
        $today = Carbon::today()->format('Y-m-d');
        
        $seances_today = Seance::where('formateur_id', $formateur_id)
            ->where('date', $today)
            ->with('groupe')
            ->orderBy('heure_debut')
            ->get();
            
        $seances_a_venir = Seance::where('formateur_id', $formateur_id)
            ->where('date', '>=', $today)
            ->where('statut', 'planifiee')
            ->count();
            
        return view('formateur.dashboard', compact('seances_today', 'seances_a_venir'));
    }

    public function historique() { return view('formateur.historique'); }
}
