<?php

namespace Database\Seeders;

use App\Common\Helpers\GroupHelper;
use App\Components\Courses\Models\Course;
use App\Components\Groups\Models\Group;
use App\Components\Instructors\Models\Instructor;
use Illuminate\Database\Seeder;

class GroupsSeeder extends Seeder
{
    public function run()
    {
        $instructors = Instructor::where('is_practician', '=', false)->get();
        $courses = Course::all();

        $course = $courses->random();
        Group::create([
            'name'                  => GroupHelper::GenerateGroupName($course->category),
            'studying_start_date'   => '2022-02-01',
            'studying_end_date'     => '2022-06-25',
            'examen_date'           => '2022-06-26',
            'instructor_id'         => $instructors->random()->id,
            'course_id'             => $course->id,
        ]);

        $course = $courses->random();
        Group::create([
            'name'                  => GroupHelper::GenerateGroupName($course->category),
            'studying_start_date'   => '2022-02-01',
            'studying_end_date'     => '2022-06-25',
            'examen_date'           => '2022-06-26',
            'instructor_id'         => $instructors->random()->id,
            'course_id'             => $course->id,
        ]);

        $course = $courses->random();
        Group::create([
            'name'                  => GroupHelper::GenerateGroupName($course->category),
            'studying_start_date'   => '2022-02-01',
            'studying_end_date'     => '2022-06-25',
            'examen_date'           => '2022-06-26',
            'instructor_id'         => $instructors->random()->id,
            'course_id'             => $course->id,
        ]);
    }
}
