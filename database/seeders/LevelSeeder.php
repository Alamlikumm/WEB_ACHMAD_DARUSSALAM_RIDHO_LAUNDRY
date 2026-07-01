<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Level;

class LevelSeeder extends Seeder
{
    public function run(): void
    {
        $levels = [
            ['level_name' => 'Administrator'],
            ['level_name' => 'Operator'],
            ['level_name' => 'Pimpinan'],
        ];

        foreach ($levels as $level) {
            Level::create($level);
        }
    }
}
