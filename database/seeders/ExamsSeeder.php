<?php

namespace Database\Seeders;

use App\Components\Exams\Models\Exam;
use App\Components\Students\Models\Student;
use Faker\Factory;
use Illuminate\Database\Seeder;

class ExamsSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create();
        $students = Student::all();

        foreach ($students as $student) {
            Exam::create([
                'name'          => 'Какой то там экзамен',
                'mark'          => $faker->numberBetween(0, 5),
                'student_id'    => $student->id,
                'date'          => $faker->dateTimeBetween('2022-02-01', '2022-06-26')
            ]);
        }
    }
}
