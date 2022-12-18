<?php

namespace App\Components\Exams\BusinessLayer;

use App\Components\Exams\Models\Exam;
use App\Components\Students\Models\Student;
use Exception;
use Illuminate\Support\Facades\DB;

class Update
{
    /**
     * @throws Exception
     */
    public static function one(array $data, string $id, string $studentId): array
    {
        $student = Student::find($studentId);
        if (!$student) {
            throw new Exception("Студент $studentId не найден");
        }

        $exam = Exam::find($id);
        if (!$exam) {
            throw new Exception("Экзамен $id не найдена");
        }

        try {
            DB::beginTransaction();

            $exam->update($data);

            DB::commit();
        }
        catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return Read::byId($studentId, (string) $exam->id);
    }
}
