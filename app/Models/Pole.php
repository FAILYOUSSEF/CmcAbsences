<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pole extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'description'];

    public function filieres()
    {
        return $this->hasMany(Filiere::class);
    }

    public function groupes()
    {
        return $this->hasMany(Groupe::class);
    }

    public function formateurs()
    {
        return $this->hasMany(Formateur::class);
    }

    public function gestionnaires()
    {
        return $this->hasMany(GestionnaireStag::class);
    }
}
