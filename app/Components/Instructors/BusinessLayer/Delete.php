<?php

namespace App\Components\Instructors\BusinessLayer;

use App\Common\Exceptions\DataBaseException;
use App\Components\Instructors\Models\Instructor;
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
        $instructor = Instructor::find($id);
        if (!$instructor) {
            throw new DataBaseException("Инструктор с id $id не найден");
        }

        try {
            DB::beginTransaction();

            $instructor->delete();

            DB::commit();
        }
        catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return Read::trashed((string) $instructor->id);
    }
}
