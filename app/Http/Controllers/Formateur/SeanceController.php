<?php

namespace App\Http\Controllers\Formateur;

use App\Http\Controllers\Controller;
use App\Models\Seance;
use App\Models\Groupe;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SeanceController extends Controller
{
    public function index()
    {
        $formateur_id = auth()->user()->formateur->id;
        $seances = Seance::where('formateur_id', $formateur_id)
            ->with('groupe')
            ->orderBy('date', 'desc')
            ->paginate(15);
        return view('formateur.seances.index', compact('seances'));
    }

    public function create()
    {
        $formateur = auth()->user()->formateur;
        $groupes = Groupe::where('pole_id', $formateur->pole_id)->get();
        return view('formateur.seances.create', compact('groupes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'heure_debut' => 'required',
            'heure_fin' => 'required|after:heure_debut',
            'module' => 'required|string|max:255',
            'salle' => 'required|string|max:100',
            'groupe_id' => 'required|exists:groupes,id',
        ]);

        Seance::create([
            'date' => $request->date,
            'heure_debut' => $request->heure_debut,
            'heure_fin' => $request->heure_fin,
            'module' => $request->module,
            'salle' => $request->salle,
            'groupe_id' => $request->groupe_id,
            'formateur_id' => auth()->user()->formateur->id,
        ]);

        return redirect()->route('formateur.seances.index')->with('success', 'Séance créée avec succès.');
    }

    public function show(Seance $seance)
    {
        $seance->load('presences.stagiaire', 'groupe');
        return view('formateur.seances.show', compact('seance'));
    }

    public function edit(Seance $seance)
    {
        $formateur = auth()->user()->formateur;
        $groupes = Groupe::where('pole_id', $formateur->pole_id)->get();
        return view('formateur.seances.create', compact('seance', 'groupes'));
    }

    public function update(Request $request, Seance $seance)
    {
        $request->validate([
            'date' => 'required|date',
            'heure_debut' => 'required',
            'heure_fin' => 'required|after:heure_debut',
            'module' => 'required|string|max:255',
            'salle' => 'required|string|max:100',
            'groupe_id' => 'required|exists:groupes,id',
        ]);

        $seance->update($request->only('date', 'heure_debut', 'heure_fin', 'module', 'salle', 'groupe_id'));
        return redirect()->route('formateur.seances.index')->with('success', 'Séance mise à jour avec succès.');
    }

    public function destroy(Seance $seance)
    {
        $seance->delete();
        return redirect()->route('formateur.seances.index')->with('success', 'Séance supprimée avec succès.');
    }
}
