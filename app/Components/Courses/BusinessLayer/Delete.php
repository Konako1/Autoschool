<?php

namespace App\Components\Courses\BusinessLayer;

use App\Common\Exceptions\DataBaseException;
use App\Components\Courses\Models\Course;
use App\Components\Courses\Models\CourseModule;
use App\Components\Students\Models\Student;
use Exception;
use Illuminate\Support\Facades\DB;

class Delete
{
    /**
     * @throws Exception
     */
    public static function one(string $id): array
    {
        $course = Course::find($id);
        if (!$course) {
            throw new DataBaseException("Курс с id $id не найден");
        }

        try {
            DB::beginTransaction();

            $course->delete();

            CourseModule::where('course_id', '=', $id)->delete();

            DB::commit();
        }
        catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return Read::trashed((string) $course->id);
    }
}
