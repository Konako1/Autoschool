<?php

namespace Database\Seeders;

use App\Components\Courses\Models\Course;
use App\Components\Courses\Models\CourseModule;
use App\Components\Modules\Models\Module;
use Illuminate\Database\Seeder;
use Ramsey\Collection\Collection;

class CoursesSeeder extends Seeder
{
    public function run() {
        $course = Course::create([
            'name'          => 'Водитель категории А',
            'category'      => 'A',
            'price'         => 60000.00,
            'driving_hours' => 20,
        ]);
        $this->setCourseModules($course);

        $course = Course::create([
            'name'          => 'Водитель категории B',
            'category'      => 'B',
            'price'         => 45000.00,
            'driving_hours' => 20,
        ]);
        $this->setCourseModules($course);

        $course = Course::create([
            'name'          => 'Водитель категории D',
            'category'      => 'D',
            'price'         => 120000.00,
            'driving_hours' => 20,
        ]);
        $this->setCourseModules($course);
    }

    private function setCourseModules(Course $course) {
        $allModules = Module::all();
        $rndModules = Module::all()->random(count($allModules) - 1);
        foreach ($rndModules as $module) {
            $courseModules = new CourseModule([
                'course_id' => $course->id,
                'module_id' => $module->id
            ]);
            $courseModules->save();
        }
    }
}
