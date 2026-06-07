<?php

namespace Database\Seeders;

use App\Models\Filiere;
use App\Models\Formateur;
use App\Models\GestionnaireStag;
use App\Models\Groupe;
use App\Models\Pole;
use App\Models\Stagiaire;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@ofppt.ma'],
            ['name' => 'Administrateur', 'password' => Hash::make('password')]
        );
        $admin->assignRole('admin');

        // Fetch a Pole
        $poleDIA = Pole::where('nom', 'DIA')->first();

        // GS
        $gsUser = User::firstOrCreate(
            ['email' => 'gs@ofppt.ma'],
            ['name' => 'Gestionnaire DIA', 'password' => Hash::make('password')]
        );
        $gsUser->assignRole('gs');
        GestionnaireStag::firstOrCreate(
            ['user_id' => $gsUser->id],
            ['nom' => 'Gestionnaire', 'prenom' => 'DIA', 'pole_id' => $poleDIA->id]
        );

        // Formateur
        $formateurUser = User::firstOrCreate(
            ['email' => 'formateur@ofppt.ma'],
            ['name' => 'Formateur DEV', 'password' => Hash::make('password')]
        );
        $formateurUser->assignRole('formateur');
        $formateur = Formateur::firstOrCreate(
            ['user_id' => $formateurUser->id],
            ['nom' => 'Formateur', 'prenom' => 'DEV', 'email' => 'formateur@ofppt.ma', 'pole_id' => $poleDIA->id, 'specialite' => 'Développement']
        );

        // Filiere & Groupe
        $filiere = Filiere::firstOrCreate(['nom' => 'Développement Digital', 'pole_id' => $poleDIA->id]);
        $groupe = Groupe::firstOrCreate([
            'nom' => 'DEV101', 'annee_formation' => date('Y'),
            'filiere_id' => $filiere->id, 'pole_id' => $poleDIA->id
        ]);
        $groupe2 = Groupe::firstOrCreate([
            'nom' => 'DEV102', 'annee_formation' => date('Y'),
            'filiere_id' => $filiere->id, 'pole_id' => $poleDIA->id
        ]);

        // Stagiaires
        for ($i = 1; $i <= 10; $i++) {
            Stagiaire::firstOrCreate([
                'cin' => 'AB' . (12345 + $i),
            ], [
                'matricule' => '202300' . $i,
                'nom' => 'Nom' . $i,
                'prenom' => 'Prenom' . $i,
                'groupe_id' => $groupe->id,
            ]);
        }
    }
}
