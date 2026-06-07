<?php

namespace App\Services;

use App\Models\Stagiaire;
use App\Models\Alert;

class AlertService
{
    public function checkThresholds(Stagiaire $stagiaire): void
    {
        // Seuil absences : 20 heures
        if ($stagiaire->total_heures_absence >= 20) {
            $this->createAlertIfNotExists(
                $stagiaire, 
                'absence',
                "Le stagiaire {$stagiaire->nom} {$stagiaire->prenom} a dépassé 20h d'absence ({$stagiaire->total_heures_absence}h)"
            );
        }

        // Seuil retards : 5 retards
        if ($stagiaire->total_retards >= 5) {
            $this->createAlertIfNotExists(
                $stagiaire, 
                'retard',
                "Le stagiaire {$stagiaire->nom} {$stagiaire->prenom} a accumulé 5 retards ou plus ({$stagiaire->total_retards} retards)"
            );
        }
    }

    private function createAlertIfNotExists(Stagiaire $stagiaire, string $type, string $message): void
    {
        // On vérifie si une alerte non lue existe déjà pour éviter le spam
        $exists = Alert::where('stagiaire_id', $stagiaire->id)
            ->where('type', $type)
            ->where('is_read', false)
            ->exists();

        if (!$exists) {
            Alert::create([
                'stagiaire_id' => $stagiaire->id,
                'type' => $type,
                'message' => $message,
                'is_read' => false
            ]);
        }
    }
}
