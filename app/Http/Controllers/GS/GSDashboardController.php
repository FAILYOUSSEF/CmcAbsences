<?php

namespace App\Http\Controllers\GS;

use App\Http\Controllers\Controller;
use App\Models\Stagiaire;
use App\Models\Groupe;
use App\Models\Seance;
use App\Models\Alert;
use App\Models\Presence;
use Illuminate\Http\Request;
use Carbon\Carbon;

class GSDashboardController extends Controller
{
    private function getPoleId()
    {
        return auth()->user()->gestionnaireStag->pole_id;
    }

    public function index()
    {
        $pole_id = $this->getPoleId();

        $groupes_count = Groupe::where('pole_id', $pole_id)->count();
        $stagiaires_count = Stagiaire::whereHas('groupe', fn($q) => $q->where('pole_id', $pole_id))->count();
        $alerts_count = Alert::whereHas('stagiaire.groupe', fn($q) => $q->where('pole_id', $pole_id))->where('is_read', false)->count();

        // Top 5 stagiaires les plus absents
        $top_absents = Stagiaire::whereHas('groupe', fn($q) => $q->where('pole_id', $pole_id))
            ->with('groupe')
            ->get()
            ->sortByDesc('total_heures_absence')
            ->take(5);

        $stats = compact('groupes_count', 'stagiaires_count', 'alerts_count');
        return view('gs.dashboard', compact('stats', 'top_absents'));
    }

    public function groupes()
    {
        $pole_id = $this->getPoleId();
        $groupes = Groupe::where('pole_id', $pole_id)->with('filiere')->withCount('stagiaires')->paginate(10);
        return view('gs.groupes', compact('groupes'));
    }

    public function stagiaires(Request $request)
    {
        $pole_id = $this->getPoleId();
        $query = Stagiaire::whereHas('groupe', fn($q) => $q->where('pole_id', $pole_id))->with('groupe');

        if ($request->filled('groupe_id')) {
            $query->where('groupe_id', $request->groupe_id);
        }
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('nom', 'like', "%{$s}%")
                  ->orWhere('prenom', 'like', "%{$s}%")
                  ->orWhere('matricule', 'like', "%{$s}%")
                  ->orWhere('cin', 'like', "%{$s}%");
            });
        }

        $stagiaires = $query->paginate(15);
        $groupes = Groupe::where('pole_id', $pole_id)->get();
        return view('gs.stagiaires', compact('stagiaires', 'groupes'));
    }

    public function statistiques()
    {
        $pole_id = $this->getPoleId();
        $groupes = Groupe::where('pole_id', $pole_id)->with('stagiaires')->get();

        // Calcul des stats par groupe
        $groupeStats = $groupes->map(function ($groupe) {
            $totalAbsences = 0;
            $totalRetards = 0;
            foreach ($groupe->stagiaires as $s) {
                $totalAbsences += $s->total_heures_absence;
                $totalRetards += $s->total_retards;
            }
            return [
                'nom' => $groupe->nom,
                'stagiaires' => $groupe->stagiaires->count(),
                'total_absences' => $totalAbsences,
                'total_retards' => $totalRetards,
            ];
        });

        return view('gs.statistiques', compact('groupeStats'));
    }

    public function alerts()
    {
        $pole_id = $this->getPoleId();
        $alerts = Alert::whereHas('stagiaire.groupe', fn($q) => $q->where('pole_id', $pole_id))
            ->with('stagiaire.groupe')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        // Mark as read
        Alert::whereHas('stagiaire.groupe', fn($q) => $q->where('pole_id', $pole_id))
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('gs.alerts', compact('alerts'));
    }

    public function show($id)
    {
        $pole_id = $this->getPoleId();
        $stagiaire = Stagiaire::whereHas('groupe', fn($q) => $q->where('pole_id', $pole_id))
            ->with(['groupe.filiere', 'alerts'])
            ->findOrFail($id);

        $history = $stagiaire->presences()
            ->with('seance.formateur')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('gs.show', compact('stagiaire', 'history'));
    }
}
