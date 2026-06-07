<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pole;
use Illuminate\Http\Request;

class PoleController extends Controller
{
    public function index()
    {
        $poles = Pole::withCount(['filieres', 'groupes', 'formateurs', 'gestionnaires'])->paginate(10);
        return view('admin.poles.index', compact('poles'));
    }

    public function create()
    {
        return view('admin.poles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255|unique:poles',
            'description' => 'nullable|string',
        ]);

        Pole::create($request->all());

        return redirect()->route('admin.poles.index')->with('success', 'Pôle créé avec succès.');
    }

    public function show(Pole $pole)
    {
        return view('admin.poles.show', compact('pole'));
    }

    public function edit(Pole $pole)
    {
        return view('admin.poles.create', compact('pole'));
    }

    public function update(Request $request, Pole $pole)
    {
        $request->validate([
            'nom' => 'required|string|max:255|unique:poles,nom,' . $pole->id,
            'description' => 'nullable|string',
        ]);

        $pole->update($request->all());

        return redirect()->route('admin.poles.index')->with('success', 'Pôle mis à jour avec succès.');
    }

    public function destroy(Pole $pole)
    {
        $pole->delete();
        return redirect()->route('admin.poles.index')->with('success', 'Pôle supprimé avec succès.');
    }
}
