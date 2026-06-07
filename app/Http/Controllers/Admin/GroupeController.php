<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Groupe;
use App\Models\Filiere;
use App\Models\Pole;
use Illuminate\Http\Request;

class GroupeController extends Controller
{
    public function index()
    {
        $groupes = Groupe::with(['filiere', 'pole'])->withCount('stagiaires')->paginate(10);
        return view('admin.groupes.index', compact('groupes'));
    }

    public function create()
    {
        $poles = Pole::all();
        $filieres = Filiere::all();
        return view('admin.groupes.create', compact('poles', 'filieres'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255|unique:groupes',
            'annee_formation' => 'required|integer|min:2020|max:2030',
            'filiere_id' => 'required|exists:filieres,id',
            'pole_id' => 'required|exists:poles,id',
        ]);

        Groupe::create($request->all());
        return redirect()->route('admin.groupes.index')->with('success', 'Groupe créé avec succès.');
    }

    public function show(Groupe $groupe)
    {
        $groupe->load('stagiaires', 'filiere', 'pole');
        return view('admin.groupes.show', compact('groupe'));
    }

    public function edit(Groupe $groupe)
    {
        $poles = Pole::all();
        $filieres = Filiere::all();
        return view('admin.groupes.create', compact('groupe', 'poles', 'filieres'));
    }

    public function update(Request $request, Groupe $groupe)
    {
        $request->validate([
            'nom' => 'required|string|max:255|unique:groupes,nom,' . $groupe->id,
            'annee_formation' => 'required|integer|min:2020|max:2030',
            'filiere_id' => 'required|exists:filieres,id',
            'pole_id' => 'required|exists:poles,id',
        ]);

        $groupe->update($request->all());
        return redirect()->route('admin.groupes.index')->with('success', 'Groupe mis à jour avec succès.');
    }

    public function destroy(Groupe $groupe)
    {
        $groupe->delete();
        return redirect()->route('admin.groupes.index')->with('success', 'Groupe supprimé avec succès.');
    }
}
