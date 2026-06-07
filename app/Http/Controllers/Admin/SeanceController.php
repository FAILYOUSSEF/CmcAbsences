<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Seance;
use App\Models\Groupe;
use App\Models\Formateur;
use Illuminate\Http\Request;

class SeanceController extends Controller
{
    public function index()
    {
        $seances = Seance::with(['groupe', 'formateur'])->orderBy('date', 'desc')->paginate(15);
        return view('admin.seances.index', compact('seances'));
    }

    public function create()
    {
        $groupes = Groupe::all();
        $formateurs = Formateur::all();
        return view('admin.seances.create', compact('groupes', 'formateurs'));
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
            'formateur_id' => 'required|exists:formateurs,id',
        ]);

        Seance::create($request->all());
        return redirect()->route('admin.seances.index')->with('success', 'Séance créée avec succès.');
    }

    public function show(Seance $seance)
    {
        $seance->load('presences.stagiaire', 'groupe', 'formateur');
        return view('admin.seances.show', compact('seance'));
    }

    public function edit(Seance $seance)
    {
        $groupes = Groupe::all();
        $formateurs = Formateur::all();
        return view('admin.seances.create', compact('seance', 'groupes', 'formateurs'));
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
            'formateur_id' => 'required|exists:formateurs,id',
        ]);

        $seance->update($request->all());
        return redirect()->route('admin.seances.index')->with('success', 'Séance mise à jour avec succès.');
    }

    public function destroy(Seance $seance)
    {
        $seance->delete();
        return redirect()->route('admin.seances.index')->with('success', 'Séance supprimée avec succès.');
    }
}
