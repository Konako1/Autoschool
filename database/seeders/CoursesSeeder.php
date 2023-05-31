<?php

namespace Database\Seeders;

use App\Components\Categories\Models\Category;
use App\Components\Courses\Models\Course;
use App\Components\Courses\Models\CourseModule;
use App\Components\Instructors\Models\Instructor;
use App\Components\Modules\Models\Module;
use Illuminate\Database\Seeder;

class CoursesSeeder extends Seeder
{
    public function run() {
        $instructors = Instructor::where('is_practician', '=', false)->get();
        $categories = Category::all();

        $category3 = $categories->find(3);
        $category4 = $categories->find(4);
        $category10 = $categories->find(10);
        $course = Course::create([
            'name'          => "Водитель категории $category3->name",
            'price'         => 60000.00,
            'driving_hours' => 20,
            'category_id'   => $category3->id,
            'instructor_id' => $instructors->where('category_id', '=', $category3->id)->random()->id,
        ]);
        $this->setCourseModules($course);

        $course = Course::create([
            'name'          => "Водитель категории $category10->name",
            'price'         => 45000.00,
            'driving_hours' => 20,
            'category_id'   => $category10->id,
            'instructor_id' => $instructors->where('category_id', '=', $category10->id)->random()->id,
        ]);
        $this->setCourseModules($course);

        $course = Course::create([
            'name'          => "Водитель категории $category4->name",
            'price'         => 120000.00,
            'driving_hours' => 20,
            'category_id'   => $category4->id,
            'instructor_id' => $instructors->where('category_id', '=', $category4->id)->random()->id,
        ]);
        $this->setCourseModules($course);
    }

    private function setCourseModules(Course $course) {
        $allModules = Module::where('metadata', 'not like', 'exam')->get();
        $rndModules = Module::where('metadata', 'not like', 'exam')->get()->random(count($allModules) - 1);
        foreach ($rndModules as $module) {
            CourseModule::create([
                'course_id' => $course->id,
                'module_id' => $module->id
            ]);
        }
    }
}
