<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run()
    {

        $faker = Faker::create();

        $categories = DB::table('categories')->pluck('id');
        $userIds = DB::table('users')->pluck('id');
        $priorityIds = DB::table('priorities')->pluck('id');

        for ($i = 0; $i < 10; $i++) {
            $taskId = DB::table('tasks')->insertGetId([
                'title' => $faker->sentence,
                'description' => $faker->paragraph,
                'user_id' => $faker->randomElement($userIds),
                'category_id' => $faker->randomElement($categories),
                'priority_id' => $faker->randomElement($priorityIds),
                'due_date' => $faker->dateTimeBetween('now', '+1 month'),
                'slug' => $faker->slug,
                'is_completed' => $faker->boolean,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            for ($j = 0; $j < 2; $j++) {
                $financialTaskId = DB::table('task_financials')->insertGetId([
                    'title' => $faker->sentence,
                    'slug' => $faker->slug,
                    'amount' => $faker->randomFloat(2, 100, 1000),
                    'currency' => 'USD',
                    'transaction_date' => $faker->dateTimeThisYear,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                DB::table('financial_task')->insert([
                    'task_id' => $taskId,
                    'task_financial_id' => $financialTaskId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
