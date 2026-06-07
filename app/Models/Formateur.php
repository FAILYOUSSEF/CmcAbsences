<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formateur extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'nom', 'prenom', 'email', 'telephone', 'specialite', 'pole_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pole()
    {
        return $this->belongsTo(Pole::class);
    }

    public function seances()
    {
        return $this->hasMany(Seance::class);
    }
}
