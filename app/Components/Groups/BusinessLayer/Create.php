<?php

namespace App\Components\Groups\BusinessLayer;

use App\Common\Exceptions\DataBaseException;
use App\Common\Exceptions\KnownException;
use App\Common\Helpers\GroupHelper;
use App\Common\Helpers\LecturesGenerator;
use App\Components\Courses\Models\Course;
use App\Components\Groups\Models\Group;
use App\Components\Groups\Models\GroupWeekday;
use App\Components\Instructors\Models\Instructor;
use App\Components\Lessons\Models\Lesson;
use App\Components\Timings\Models\Timing;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class Create
{
    /**
     * @throws Exception
     */
    public static function one(array $data, string $course_id, string $timing_id): array
    {
        $course = Course::find($course_id);
        if (!$course) {
            throw new DataBaseException("Курс с id $course_id не найден");
        }

        $timing = Timing::find($timing_id);
        if (!$timing) {
            throw new DataBaseException("Время с id $timing_id не найдено");
        }

        $data['name'] = GroupHelper::GenerateGroupName($course->category);
        $data['studying_end_date'] = Carbon::createFromTimestamp(0);

        try {
            DB::beginTransaction();

            $group = Group::create($data);

            foreach ($data['weekdays'] as $weekday) {
                GroupWeekday::create([
                    'group_id' => $group->id,
                    'weekday_id' => $weekday
                ]);
            }

            LecturesGenerator::generate($group);

            DB::commit();
        }
        catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return Read::byId((string) $group->id);
    }
}
