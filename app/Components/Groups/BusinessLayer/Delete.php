<?php

namespace App\Components\Groups\BusinessLayer;

use App\Common\Exceptions\DataBaseException;
use App\Components\Groups\Models\Group;
use App\Components\Students\Models\Student;
use Exception;
use Illuminate\Support\Facades\DB;

class Delete
{
    /**
     * @throws Exception
     */
    public static function one(string $id): array
    {
        $group = Group::find($id);
        if (!$group) {
            throw new DataBaseException("Группа с id $id не найдена");
        }

        try {
            DB::beginTransaction();

            Student::where('group_id', $group->id)->delete();

            $group->delete();

            DB::commit();
        }
        catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return Read::trashed((string) $group->id);
    }
}
