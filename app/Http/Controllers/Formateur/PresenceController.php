<?php

namespace App\Http\Controllers\Formateur;

use App\Http\Controllers\Controller;
use App\Models\Seance;
use App\Models\Presence;
use Illuminate\Http\Request;

class PresenceController extends Controller
{
    public function create(Seance $seance)
    {
        // On récupère les stagiaires du groupe
        $stagiaires = $seance->groupe->stagiaires()->where('statut', 'actif')->orderBy('nom')->get();
        
        // On vérifie si l'appel a déjà été fait
        $presences = $seance->presences->keyBy('stagiaire_id');
        
        return view('formateur.presences.create', compact('seance', 'stagiaires', 'presences'));
    }

    public function store(Request $request, Seance $seance)
    {
        $request->validate([
            'presences' => 'required|array',
            'presences.*.statut' => 'required|in:present,absent,retard',
            'presences.*.minutes_retard' => 'nullable|integer|min:1',
        ]);

        foreach ($request->presences as $stagiaire_id => $data) {
            Presence::updateOrCreate(
                [
                    'seance_id' => $seance->id,
                    'stagiaire_id' => $stagiaire_id
                ],
                [
                    'statut' => $data['statut'],
                    'minutes_retard' => $data['statut'] === 'retard' ? ($data['minutes_retard'] ?? 15) : null,
                ]
            );
        }

        $seance->update(['statut' => 'terminee']);

        return redirect()->route('formateur.dashboard')->with('success', 'Appel enregistré avec succès.');
    }
}
