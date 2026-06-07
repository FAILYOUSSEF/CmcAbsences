<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'annee_formation', 'filiere_id', 'pole_id'];

    public function filiere()
    {
        return $this->belongsTo(Filiere::class);
    }

    public function pole()
    {
        return $this->belongsTo(Pole::class);
    }

    public function stagiaires()
    {
        return $this->hasMany(Stagiaire::class);
    }

    public function seances()
    {
        return $this->hasMany(Seance::class);
    }
}
