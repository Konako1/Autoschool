<?php

namespace Database\Seeders;

use App\Components\Groups\Models\Group;
use App\Components\Students\Models\Student;
use Faker\Factory;
use Illuminate\Database\Seeder;

class StudentsSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create();
        $groups = Group::all();

        for ($i = 0; $i < 100; $i++) {
            Student::create([
                'payment_needed'    => doubleval($faker->numerify('#####.##')),
                'group_id'          => $groups->random()->id,
                'name'              => $faker->name,
                'surname'           => $faker->lastName,
                'patronymic'        => $faker->firstName,
                'birthday'          => $faker->unique()->dateTime,
                'photo_path'        => $faker->numerify('photo###'),
                'phone'             => $faker->numerify('8##########'),
                'address'           => $faker->address,
            ]);
        }
    }
}
