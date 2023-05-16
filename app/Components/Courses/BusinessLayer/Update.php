<?php

namespace App\Components\Courses\BusinessLayer;

use App\Common\Exceptions\DataBaseException;
use App\Common\Exceptions\KnownException;
use App\Components\Courses\Models\Course;
use App\Components\Courses\Models\CourseModule;
use App\Components\Modules\Models\Module;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class Update
{
    /**
     * @throws Exception
     */
    public static function one(array $data, string $id): array
    {
        $course = Course::find($id);
        if (!$course) {
            throw new DataBaseException("Курс с id $id не найден");
        }

        $modulesId = $data['modules'];
        $modules = [];

        try {
            DB::beginTransaction();

            foreach ($modulesId as $moduleId) {
                try {
                    $module = Module::findOrFail($moduleId);
                    $modules[] = $module;
                }
                catch (ModelNotFoundException $e) {
                    throw new KnownException("Модуля с id $moduleId не существует.");
                }
            }

            $course->update($data);

            CourseModule::where('course_id', '=', $course->id)->delete();

            foreach ($modules as $module) {
                $courseModules = new CourseModule();
                $courseModules->course_id = $course->id;
                $courseModules->module_id = $module->id;
                $courseModules->save();
            }

            DB::commit();
        }
        catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return Read::byId((string) $course->id);
    }
}
