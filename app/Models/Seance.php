<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seance extends Model
{
    use HasFactory;

    protected $fillable = [
        'date', 'heure_debut', 'heure_fin', 'module', 
        'salle', 'groupe_id', 'formateur_id', 'statut'
    ];

    protected $appends = ['duree_heures'];

    public function groupe()
    {
        return $this->belongsTo(Groupe::class);
    }

    public function formateur()
    {
        return $this->belongsTo(Formateur::class);
    }

    public function presences()
    {
        return $this->hasMany(Presence::class);
    }

    public function getDureeHeuresAttribute()
    {
        $debut = Carbon::parse($this->heure_debut);
        $fin = Carbon::parse($this->heure_fin);
        return $fin->diffInMinutes($debut) / 60;
    }
}
