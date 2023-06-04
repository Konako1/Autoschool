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
            $coursePrice = $student->group()->course()->price;
            $rand = random_int(0, 2);
            if ($rand == 0)
                $value = $coursePrice;
            elseif ($rand == 1)
                $value = $coursePrice / 2;
            else
                $value = 0;

            Payment::create([
                'value'         => $value,
                'student_id'    => $student->id,
                'date'          => $faker->dateTimeBetween('2022-02-01', '2022-06-26')
            ]);
        }
    }
}
