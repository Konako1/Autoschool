<?php

namespace Database\Seeders;

use App\Components\Courses\Models\Course;
use Illuminate\Database\Seeder;

class CoursesSeeder extends Seeder
{
    public function run() {
        Course::create([
            'name'          => 'Водитель категории А',
            'category'      => 'A',
            'price'         => 60000.00,
        ]);
        Course::create([
            'name'          => 'Водитель категории B',
            'category'      => 'B',
            'price'         => 45000.00,
        ]);
        Course::create([
            'name'          => 'Водитель категории D',
            'category'      => 'D',
            'price'         => 120000.00,
        ]);
    }
}
