<?php

namespace App\Components\Lessons\BusinessLayer;

use App\Common\Exceptions\DataBaseException;
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

        try {
            DB::beginTransaction();

            $lesson->delete();

            DB::commit();
        }
        catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return Read::trashed((string) $lesson->id);
    }
}
