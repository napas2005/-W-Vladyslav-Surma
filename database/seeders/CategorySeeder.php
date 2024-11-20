<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    private function translateToUkrainian($category, $faker)
    {
        $translations = [
            'Family' => 'Сім\'я',
            'Work' => 'Робота',
            'Health' => 'Здоров\'я',
            'Finance' => 'Фінанси',
        ];

        return $translations[$category] ?? $faker->word;
    }

    public function run()
    {
        $faker = Faker::create();
        $categories = ['Family', 'Work', 'Health', 'Finance'];

        foreach ($categories as $category) {
            $categoryId = DB::table('categories')->insertGetId([
                'active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('category_translations')->insert([
                'category_id' => $categoryId,
                'locale' => 'en',
                'title' => $category,
                'slug' => $faker->slug,
                'description' => $faker->sentence,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('category_translations')->insert([
                'category_id' => $categoryId,
                'locale' => 'uk',
                'title' =>  $this->translateToUkrainian($category, $faker),
                'slug' => $faker->slug,
                'description' => $faker->sentence,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
