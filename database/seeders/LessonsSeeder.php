<?php

namespace Database\Seeders;

use App\Common\Helpers\LecturesGenerator;
use App\Components\Groups\Models\Group;
use Illuminate\Database\Seeder;

class LessonsSeeder extends Seeder
{
    public function run()
    {
        $groups = Group::all();
        foreach ($groups as $group) {
            LecturesGenerator::generate($group);
        }
    }
}
