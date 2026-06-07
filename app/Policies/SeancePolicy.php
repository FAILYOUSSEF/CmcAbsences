<?php

namespace App\Policies;

use App\Models\Seance;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SeancePolicy
{
    public function before(User $user, string $ability): bool|null
    {
        if ($user->hasRole('admin')) {
            return true;
        }
        return null;
    }

    public function viewAny(User $user): bool
    {
        return $user->hasRole('formateur') || $user->hasRole('gs');
    }

    public function view(User $user, Seance $seance): bool
    {
        if ($user->hasRole('gs')) {
            return $seance->groupe->pole_id === $user->gestionnaireStag->pole_id;
        }
        return $user->formateur && $user->formateur->id === $seance->formateur_id;
    }

    public function create(User $user): bool
    {
        return $user->hasRole('formateur');
    }

    public function update(User $user, Seance $seance): bool
    {
        return $user->formateur && $user->formateur->id === $seance->formateur_id;
    }

    public function delete(User $user, Seance $seance): bool
    {
        return $user->formateur && $user->formateur->id === $seance->formateur_id;
    }
}
