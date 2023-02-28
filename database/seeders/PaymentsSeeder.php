<?php

namespace Database\Seeders;

use App\Components\Payments\Models\Payment;
use App\Components\Students\Models\Student;
use Faker\Factory;
use Illuminate\Database\Seeder;

class PaymentsSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create();
        $students = Student::all();

        foreach ($students as $student) {
            Payment::create([
                'value'         => doubleval($faker->numerify('####.##')),
                'student_id'    => $student->id,
                'date'          => $faker->dateTimeBetween('2022-02-01', '2022-06-26')
            ]);
        }
    }
}
