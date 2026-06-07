<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Formateur;
use App\Models\Pole;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class FormateurController extends Controller
{
    public function index()
    {
        $formateurs = Formateur::with(['pole', 'user'])->paginate(10);
        return view('admin.formateurs.index', compact('formateurs'));
    }

    public function create()
    {
        $poles = Pole::all();
        return view('admin.formateurs.create', compact('poles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'telephone' => 'nullable|string|max:20',
            'specialite' => 'nullable|string|max:255',
            'pole_id' => 'required|exists:poles,id',
        ]);

        $user = User::create([
            'name' => $request->prenom . ' ' . $request->nom,
            'email' => $request->email,
            'password' => Hash::make('password'),
        ]);
        $user->assignRole('formateur');

        Formateur::create([
            'user_id' => $user->id,
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'specialite' => $request->specialite,
            'pole_id' => $request->pole_id,
        ]);

        return redirect()->route('admin.formateurs.index')->with('success', 'Formateur créé avec succès. Mot de passe par défaut: password');
    }

    public function show(Formateur $formateur)
    {
        return view('admin.formateurs.show', compact('formateur'));
    }

    public function edit(Formateur $formateur)
    {
        $poles = Pole::all();
        return view('admin.formateurs.create', compact('formateur', 'poles'));
    }

    public function update(Request $request, Formateur $formateur)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:formateurs,email,' . $formateur->id,
            'telephone' => 'nullable|string|max:20',
            'specialite' => 'nullable|string|max:255',
            'pole_id' => 'required|exists:poles,id',
        ]);

        $formateur->update($request->all());
        $formateur->user->update(['name' => $request->prenom . ' ' . $request->nom, 'email' => $request->email]);

        return redirect()->route('admin.formateurs.index')->with('success', 'Formateur mis à jour avec succès.');
    }

    public function destroy(Formateur $formateur)
    {
        $formateur->user->delete();
        $formateur->delete();
        return redirect()->route('admin.formateurs.index')->with('success', 'Formateur supprimé avec succès.');
    }
}
