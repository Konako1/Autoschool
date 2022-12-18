<?php

namespace App\Components\Lessons\BusinessLayer;

use App\Components\Groups\Models\Group;
use App\Components\Lessons\Models\Lesson;
use App\Components\Modules\Models\Module;
use Exception;
use Illuminate\Support\Facades\DB;

class Create
{
    /**
     * @throws Exception
     */
    public static function one(array $data, string $moduleId, string $groupId): array
    {
        $module = Module::find($moduleId);
        if (!$module) {
            throw new Exception("Модуль $moduleId не найден");
        }

        $group = Group::find($groupId);
        if (!$group) {
            throw new Exception("Группа $groupId не найдена");
        }

        try {
            DB::beginTransaction();

            $lesson = Lesson::create($data);

            DB::commit();
        }
        catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return Read::byId($moduleId, $groupId, (string) $lesson->id);
    }
}
