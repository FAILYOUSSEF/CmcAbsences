<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stagiaire;
use App\Models\Groupe;
use Illuminate\Http\Request;

class StagiaireController extends Controller
{
    public function index()
    {
        $stagiaires = Stagiaire::with('groupe')->paginate(15);
        return view('admin.stagiaires.index', compact('stagiaires'));
    }

    public function create()
    {
        $groupes = Groupe::all();
        return view('admin.stagiaires.create', compact('groupes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'matricule' => 'required|string|max:20|unique:stagiaires',
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'cin' => 'required|string|max:20|unique:stagiaires',
            'email' => 'nullable|email|max:255',
            'telephone' => 'nullable|string|max:20',
            'groupe_id' => 'required|exists:groupes,id',
            'statut' => 'required|in:actif,inactif',
        ]);

        Stagiaire::create($request->all());
        return redirect()->route('admin.stagiaires.index')->with('success', 'Stagiaire ajouté avec succès.');
    }

    public function show(Stagiaire $stagiaire)
    {
        $stagiaire->load('groupe', 'presences.seance');
        return view('admin.stagiaires.show', compact('stagiaire'));
    }

    public function edit(Stagiaire $stagiaire)
    {
        $groupes = Groupe::all();
        return view('admin.stagiaires.create', compact('stagiaire', 'groupes'));
    }

    public function update(Request $request, Stagiaire $stagiaire)
    {
        $request->validate([
            'matricule' => 'required|string|max:20|unique:stagiaires,matricule,' . $stagiaire->id,
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'cin' => 'required|string|max:20|unique:stagiaires,cin,' . $stagiaire->id,
            'email' => 'nullable|email|max:255',
            'telephone' => 'nullable|string|max:20',
            'groupe_id' => 'required|exists:groupes,id',
            'statut' => 'required|in:actif,inactif',
        ]);

        $stagiaire->update($request->all());
        return redirect()->route('admin.stagiaires.index')->with('success', 'Stagiaire mis à jour avec succès.');
    }

    public function destroy(Stagiaire $stagiaire)
    {
        $stagiaire->delete();
        return redirect()->route('admin.stagiaires.index')->with('success', 'Stagiaire supprimé avec succès.');
    }
}
