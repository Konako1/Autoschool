<?php

namespace App\Components\Lessons\BusinessLayer;

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
            throw new Exception("Модуль $moduleId не найден");
        }

        $group = Group::find($groupId);
        if (!$group) {
            throw new Exception("Группа $groupId не найдена");
        }

        $lesson = Lesson::find($id);
        if (!$lesson) {
            throw new Exception("Занятие $id не найдено");
        }

        try {
            DB::beginTransaction();

            $lesson->update($data);

            DB::commit();
        }
        catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return Read::byId($moduleId, $groupId, (string) $lesson->id);
    }
}
