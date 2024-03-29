<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            WeekdaysSeeder::class,
            TimingsSeeder::class,
            CategoriesSeeder::class,
            CarsSeeder::class,
            InstructorsSeeder::class,
            ModulesSeeder::class,
            CoursesSeeder::class,
            GroupsSeeder::class,
            LessonsSeeder::class,
            StudentsSeeder::class,
            PaymentsSeeder::class
        ]);
    }
}
