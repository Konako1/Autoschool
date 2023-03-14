<?php

namespace App\Components\Exams\BusinessLayer;

use App\Common\Exceptions\DataBaseException;
use App\Components\Exams\Models\Exam;
use App\Components\Students\Models\Student;
use Exception;
use Illuminate\Support\Facades\DB;

class Delete
{
    /**
     * @throws Exception
     */
    public static function one(string $id, string $studentId): array
    {
        $student = Student::find($studentId);
        if (!$student) {
            throw new DataBaseException("Студент с id $studentId не найден");
        }

        $exam = Exam::find($id);
        if (!$exam) {
            throw new DataBaseException("Экзамен с id $id не найден");
        }

        try {
            DB::beginTransaction();

            $exam->delete();

            DB::commit();
        }
        catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return Read::trashed($studentId, (string) $exam->id);
    }
}
