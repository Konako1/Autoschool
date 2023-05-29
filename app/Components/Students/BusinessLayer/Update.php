<?php

namespace App\Components\Students\BusinessLayer;

use App\Common\Exceptions\DataBaseException;
use App\Common\Exceptions\KnownException;
use App\Components\Groups\Models\Group;
use App\Components\Instructors\Models\Instructor;
use App\Components\Students\Models\Student;
use Exception;
use Illuminate\Support\Facades\DB;

class Update
{
    /**
     * @throws Exception
     */
    public static function one(array $data, string $groupId, string $id, string $instructor_id): array
    {
        $student = Student::where('id', '=', $id, 'and')->where('group_id', '=', $groupId)->first();
        if (!$student) {
            throw new DataBaseException("Студент с id $id не найден в группе с id $groupId");
        }

        $group = Group::find($groupId);
        if (!$group) {
            throw new DataBaseException("Группа с id $groupId не найдена");
        }

        $instructor = Instructor::find($instructor_id);
        if (!$instructor) {
            throw new DataBaseException("Инструктор с id $instructor_id не найден");
        }
        if (!$instructor->is_practician) {
            throw new KnownException("Инструктором по практике не может быть лектор");
        }

        try {
            DB::beginTransaction();

            $student->update($data);

            DB::commit();
        }
        catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return Read::byId($groupId, (string) $student->id);
    }
}
