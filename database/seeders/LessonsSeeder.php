<?php

namespace Database\Seeders;

use App\Components\Groups\Models\Group;
use App\Components\Lessons\Models\Lesson;
use App\Components\Modules\Models\Module;
use Faker\Factory;
use Illuminate\Database\Seeder;

class LessonsSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create();
        $modules = Module::all();
        $groups = Group::all();

        for ($i = 0; $i < 100; $i++) {
            $timeStart = $faker->dateTimeBetween('2022-02-01', '2022-06-26');
            Lesson::create([
                'time_start'    => $timeStart,
                'time_end'      => date('Y-m-d H:i:s', strtotime('+2 hour', $timeStart->getTimestamp())),
                'module_id'     => $modules->random()->id,
                'group_id'      => $groups->random()->id,
            ]);
        }
    }
}
