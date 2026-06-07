<?php

namespace Database\Seeders;

use App\Models\Pole;
use Illuminate\Database\Seeder;

class PoleSeeder extends Seeder
{
    public function run(): void
    {
        $poles = [
            'DIA',
            'GESTION',
            'BTP',
            'AIG',
            'THR',
            'ARTISANAT',
            'INDUSTRIE',
            'AGRO',
            'AGRICULTURE',
            'LANGUE ET SOFT SKILLS'
        ];

        foreach ($poles as $pole) {
            Pole::firstOrCreate([
                'nom' => $pole
            ], [
                'description' => 'Pôle de formation ' . $pole
            ]);
        }
    }
}
