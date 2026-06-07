<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stagiaire extends Model
{
    use HasFactory;

    protected $fillable = [
        'matricule', 'nom', 'prenom', 'cin', 'email', 
        'telephone', 'photo', 'groupe_id', 'statut'
    ];

    protected $appends = [
        'total_absences', 'total_heures_absence', 
        'total_retards', 'total_minutes_retard', 'pourcentage_absence'
    ];

    public function groupe()
    {
        return $this->belongsTo(Groupe::class);
    }

    public function presences()
    {
        return $this->hasMany(Presence::class);
    }

    public function alerts()
    {
        return $this->hasMany(Alert::class);
    }

    public function getTotalAbsencesAttribute()
    {
        return $this->presences()->where('statut', 'absent')->count();
    }

    public function getTotalHeuresAbsenceAttribute()
    {
        return $this->presences()->where('statut', 'absent')->sum('heures_absence');
    }

    public function getTotalRetardsAttribute()
    {
        return $this->presences()->where('statut', 'retard')->count();
    }

    public function getTotalMinutesRetardAttribute()
    {
        return $this->presences()->where('statut', 'retard')->sum('minutes_retard');
    }

    public function getPourcentageAbsenceAttribute()
    {
        $totalSeances = Seance::where('groupe_id', $this->groupe_id)->count();
        if ($totalSeances === 0) return 0;
        return round(($this->total_absences / $totalSeances) * 100, 2);
    }
}
