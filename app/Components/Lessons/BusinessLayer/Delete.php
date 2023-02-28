<?php

namespace App\Components\Lessons\BusinessLayer;

use App\Components\Groups\Models\Group;
use App\Components\Lessons\Models\Lesson;
use App\Components\Modules\Models\Module;
use Exception;
use Illuminate\Support\Facades\DB;

class Delete
{
    /**
     * @throws Exception
     */
    public static function one(string $id, string $moduleId, string $groupId): array
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

            $lesson->delete();

            DB::commit();
        }
        catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return Read::trashed($moduleId, $groupId, (string) $lesson->id);
    }
}
