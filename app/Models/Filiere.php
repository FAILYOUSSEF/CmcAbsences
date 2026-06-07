<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filiere extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'pole_id'];

    public function pole()
    {
        return $this->belongsTo(Pole::class);
    }

    public function groupes()
    {
        return $this->hasMany(Groupe::class);
    }
}
