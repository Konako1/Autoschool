<?php

namespace App\Components\Students\BusinessLayer;

use App\Components\Groups\Models\Group;
use App\Components\Students\Models\Student;
use Exception;
use Illuminate\Support\Facades\DB;

class Delete
{
    /**
     * @throws Exception
     */
    public static function one(string $groupId, string $id): array
    {
        $group = Group::find($groupId);
        if (!$group) {
            throw new Exception("Группа $groupId не найдена");
        }

        $student = Student::where('id', '=', $id, 'and')->where('group_id', '=', $groupId)->first();
        if (!$student) {
            throw new Exception("Студент $id не найден");
        }

        try {
            DB::beginTransaction();

            $student->delete();

            DB::commit();
        }
        catch (Exception $e) {
            DB::rollBack();
            throw new Exception('Чето не так пошло');
        }

        return Read::trashed($groupId, (string) $student->id);
    }
}
