<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presence extends Model
{
    use HasFactory;

    protected $fillable = [
        'seance_id', 'stagiaire_id', 'statut', 
        'minutes_retard', 'heures_absence', 'validated'
    ];

    public function seance()
    {
        return $this->belongsTo(Seance::class);
    }

    public function stagiaire()
    {
        return $this->belongsTo(Stagiaire::class);
    }

    protected static function booted()
    {
        static::creating(function ($presence) {
            $seance = Seance::find($presence->seance_id);
            if ($seance) {
                $duree = Carbon::parse($seance->heure_fin)->diffInMinutes(Carbon::parse($seance->heure_debut));
                $dureeHeures = $duree / 60;

                if ($presence->statut === 'absent') {
                    $presence->heures_absence = $dureeHeures;
                    $presence->minutes_retard = null;
                } elseif ($presence->statut === 'retard') {
                    $presence->heures_absence = 0;
                    // minutes_retard should be provided by the formateur
                } else {
                    $presence->heures_absence = 0;
                    $presence->minutes_retard = null;
                }
            }
        });

        static::updating(function ($presence) {
            $seance = Seance::find($presence->seance_id);
            if ($seance) {
                $duree = Carbon::parse($seance->heure_fin)->diffInMinutes(Carbon::parse($seance->heure_debut));
                $dureeHeures = $duree / 60;

                if ($presence->statut === 'absent') {
                    $presence->heures_absence = $dureeHeures;
                    $presence->minutes_retard = null;
                } elseif ($presence->statut === 'retard') {
                    $presence->heures_absence = 0;
                    // minutes_retard should be provided
                } else {
                    $presence->heures_absence = 0;
                    $presence->minutes_retard = null;
                }
            }
        });
    }
}
