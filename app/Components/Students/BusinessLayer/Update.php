<?php

namespace App\Components\Students\BusinessLayer;

use App\Common\Exceptions\DataBaseException;
use App\Components\Groups\Models\Group;
use App\Components\Students\Models\Student;
use Exception;
use Illuminate\Support\Facades\DB;

class Update
{
    /**
     * @throws Exception
     */
    public static function one(array $data, string $groupId, string $id): array
    {
        $group = Group::find($groupId);
        if (!$group) {
            throw new DataBaseException("Группа с id $groupId не найдена");
        }

        $student = Student::where('id', '=', $id, 'and')->where('group_id', '=', $groupId)->first();
        if (!$student) {
            throw new DataBaseException("Студент с id $id не найден");
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
