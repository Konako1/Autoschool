<?php

namespace App\Components\Students\BusinessLayer;

use App\Common\Exceptions\DataBaseException;
use App\Common\Exceptions\KnownException;
use App\Components\Groups\Models\Group;
use App\Components\Instructors\Models\Instructor;
use App\Components\Students\Models\Student;
use Exception;
use Illuminate\Support\Facades\DB;

class Create
{
    /**
     * @throws Exception
     */
    public static function one(array $data, string $groupId, string $instructor_id, string $gearbox_type): array
    {
        if (!($gearbox_type == 'auto' or $gearbox_type == 'manual')) {
            throw new KnownException('Тип управления может быть только \'auto\' или \'manual\'');
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

            $student = Student::create($data);

            DB::commit();
        }
        catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return Read::byId($groupId, (string) $student->id);
    }
}
