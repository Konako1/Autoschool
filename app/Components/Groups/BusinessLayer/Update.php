<?php

namespace App\Components\Groups\BusinessLayer;

use App\Common\Exceptions\DataBaseException;
use App\Components\Courses\Models\Course;
use App\Components\Groups\Models\Group;
use App\Components\Timings\Models\Timing;
use Exception;
use Illuminate\Support\Facades\DB;

class Update
{
    /**
     * @throws Exception
     */
    public static function one(array $data, string $id, string $course_id, string $timing_id): array
    {
        $group = Group::find($id);
        if (!$group) {
            throw new DataBaseException("Группа с id $id не найдена");
        }

        $course = Course::find($course_id);
        if (!$course) {
            throw new DataBaseException("Курс с id $course_id не найден");
        }

        $timing = Timing::find($timing_id);
        if (!$timing) {
            throw new DataBaseException("Время с id $timing_id не найдено");
        }

        try {
            DB::beginTransaction();

            $group->update($data);

            DB::commit();
        }
        catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return Read::byId((string) $group->id);
    }
}
