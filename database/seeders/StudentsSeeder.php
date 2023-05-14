<?php

namespace Database\Seeders;

use App\Components\Groups\Models\Group;
use App\Components\Instructors\Models\Instructor;
use App\Components\Students\Models\Student;
use Faker\Factory;
use Illuminate\Database\Seeder;

class StudentsSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create();
        $groups = Group::all();
        $instructors = Instructor::where('is_practician', '=', true)->get();
        $arr = ['auto', 'manual'];

        for ($i = 0; $i < 100; $i++) {
            Student::create([
                'group_id'          => $groups->random()->id,
                'name'              => $faker->name,
                'surname'           => $faker->lastName,
                'patronymic'        => $faker->firstName,
                'birthday'          => $faker->unique()->dateTime,
                'photo_path'        => $faker->numerify('photo###'),
                'phone'             => $faker->numerify('8##########'),
                'address'           => $faker->address,
                'instructor_id'     => $instructors->random()->id,
                'gearbox_type'      => $arr[array_rand($arr)]
            ]);
        }
    }
}
