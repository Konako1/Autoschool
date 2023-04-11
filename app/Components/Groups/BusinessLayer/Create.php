<?php

namespace App\Components\Groups\BusinessLayer;

use App\Common\Exceptions\DataBaseException;
use App\Common\Exceptions\KnownException;
use App\Common\Helpers\GroupHelper;
use App\Components\Courses\Models\Course;
use App\Components\Groups\Models\Group;
use App\Components\Instructors\Models\Instructor;
use Exception;
use Illuminate\Support\Facades\DB;

class Create
{
    /**
     * @throws Exception
     */
    public static function one(array $data, string $course_id, string $instructor_id): array
    {
        $instructor = Instructor::find($instructor_id);
        if ($instructor->is_practician) {
            throw new KnownException('Инструктором в группе не может быть практик');
        }

        $course = Course::find($course_id);
        if (!$course) {
            throw new DataBaseException("Курс с id $course_id не найден");
        }

        $data['name'] = GroupHelper::GenerateGroupName($course->category);

        try {
            DB::beginTransaction();

            $course = Group::create($data);

            DB::commit();
        }
        catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return Read::byId((string) $course->id);
    }
}
