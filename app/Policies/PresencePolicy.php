<?php

namespace App\Policies;

use App\Models\Presence;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PresencePolicy
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

    public function create(User $user): bool
    {
        return $user->hasRole('formateur');
    }

    public function update(User $user, Presence $presence): bool
    {
        // Only formateur of the seance can update, and only if not validated
        if ($presence->validated) {
            return false;
        }
        
        return $user->formateur && $user->formateur->id === $presence->seance->formateur_id;
    }

    public function validate(User $user, Presence $presence): bool
    {
        return $user->formateur && $user->formateur->id === $presence->seance->formateur_id;
    }
}
