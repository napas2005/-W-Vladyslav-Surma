<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class PrioritySeeder extends Seeder
{
    private function translateToUkrainian($priority, $faker)
    {
        $translations = [
            'High' => 'Високий',
            'Medium' => 'Середній',
            'Low' => 'Низький',
        ];

        return $translations[$priority] ?? $faker->word;
    }

    public function run()
    {
        $faker = Faker::create();
        $priorities = [
            ['title' => 'High', 'color' => '#FF0000'],
            ['title' => 'Medium', 'color' => '#FFFF00'],
            ['title' => 'Low', 'color' => '#00FF00'],
        ];

        foreach ($priorities as $priority) {
            $priorityId = DB::table('priorities')->insertGetId([
                'color' => $priority['color'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('priority_translations')->insert([
                'priority_id' => $priorityId,
                'locale' => 'uk',
                'title' => $this->translateToUkrainian($priority['title'], $faker),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('priority_translations')->insert([
                'priority_id' => $priorityId,
                'locale' => 'en',
                'title' => $priority['title'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
