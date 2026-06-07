<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    use HasFactory;

    protected $fillable = ['stagiaire_id', 'type', 'message', 'is_read'];

    public function stagiaire()
    {
        return $this->belongsTo(Stagiaire::class);
    }
}
