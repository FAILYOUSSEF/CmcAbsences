<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Filiere;
use App\Models\Pole;
use Illuminate\Http\Request;

class FiliereController extends Controller
{
    public function index()
    {
        $filieres = Filiere::with('pole')->withCount('groupes')->paginate(10);
        return view('admin.filieres.index', compact('filieres'));
    }

    public function create()
    {
        $poles = Pole::all();
        return view('admin.filieres.create', compact('poles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'pole_id' => 'required|exists:poles,id',
        ]);

        Filiere::create($request->all());

        return redirect()->route('admin.filieres.index')->with('success', 'Filière créée avec succès.');
    }

    public function show(Filiere $filiere)
    {
        return view('admin.filieres.show', compact('filiere'));
    }

    public function edit(Filiere $filiere)
    {
        $poles = Pole::all();
        return view('admin.filieres.create', compact('filiere', 'poles'));
    }

    public function update(Request $request, Filiere $filiere)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'pole_id' => 'required|exists:poles,id',
        ]);

        $filiere->update($request->all());

        return redirect()->route('admin.filieres.index')->with('success', 'Filière mise à jour avec succès.');
    }

    public function destroy(Filiere $filiere)
    {
        $filiere->delete();
        return redirect()->route('admin.filieres.index')->with('success', 'Filière supprimée avec succès.');
    }
}
