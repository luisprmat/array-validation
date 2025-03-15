<?php

namespace Database\Seeders;

use App\Models\TeamPosition;
use Illuminate\Database\Seeder;

class TeamPositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $positions = [
            'Goalkeeper' => 'Guardameta',
            'Defender' => 'Defensa',
            'Midfielder' => 'Mediocampista',
            'Forward' => 'Delantero',
            'Coach' => 'Entrenador',
            'Assistant Coach' => 'Asistente técnico',
            'Physiotherapist' => 'Fisioterapeuta',
            'Doctor' => 'Médico',
            'Manager' => 'Director',
            'President' => 'Presidente',
        ];

        $names = [];

        foreach ($positions as $en => $es) {
            $names[] = [
                'en' => $en,
                'es' => $es,
            ];
        }

        foreach ($names as $item) {
            TeamPosition::create([
                'name' => $item,
            ]);
        }
    }
}
