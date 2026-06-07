<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stagiaire;
use App\Models\Formateur;
use App\Models\Groupe;
use App\Models\Pole;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'poles' => Pole::count(),
            'groupes' => Groupe::count(),
            'formateurs' => Formateur::count(),
            'stagiaires' => Stagiaire::count(),
        ];
        
        // Calculer les absences par mois sur les 6 derniers mois
        $absencesParMois = [];
        $labelsMois = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = \Carbon\Carbon::now()->subMonths($i);
            $labelsMois[] = $date->translatedFormat('M');
            
            // Total des heures d'absence pour ce mois (approximatif pour la démo via created_at de presence)
            $totalMois = \App\Models\Presence::where('statut', 'absent')
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->sum('heures_absence');
            
            $absencesParMois[] = $totalMois;
        }

        return view('admin.dashboard', compact('stats', 'labelsMois', 'absencesParMois'));
    }
}
