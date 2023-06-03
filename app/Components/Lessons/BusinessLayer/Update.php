<?php

namespace App\Components\Lessons\BusinessLayer;

use App\Common\Exceptions\DataBaseException;
use App\Components\Groups\Models\Group;
use App\Components\Lessons\Models\Lesson;
use App\Components\Modules\Models\Module;
use App\Components\Students\Models\Student;
use Exception;
use Illuminate\Support\Facades\DB;

class Update
{
    /**
     * @throws Exception
     */
    public static function one(array $data, string $id, string $moduleId, string $groupId): array
    {
        $student = Module::find($moduleId);
        if (!$student) {
            throw new DataBaseException("Модуль с id $moduleId не найден");
        }

        $group = Group::find($groupId);
        if (!$group) {
            throw new DataBaseException("Группа с id $groupId не найдена");
        }

        $lesson = Lesson::find($id);
        if (!$lesson) {
            throw new DataBaseException("Занятие с id $id не найдено");
        }

        $dataToUpdate = [
            'moved_date' => $data['moved_date'],
            'moved_time' => $data['moved_time'],
        ];

        try {
            DB::beginTransaction();

            $lesson->update($dataToUpdate);

            DB::commit();
        }
        catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return Read::byId($moduleId, $groupId, (string) $lesson->id);
    }
}
