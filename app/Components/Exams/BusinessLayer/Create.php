<?php

namespace App\Components\Exams\BusinessLayer;

use App\Components\Exams\Models\Exam;
use App\Components\Students\Models\Student;
use Exception;
use Illuminate\Support\Facades\DB;

class Create
{
    /**
     * @throws Exception
     */
    public static function one(array $data, string $studentId): array
    {
        $student = Student::find($studentId);
        if (!$student) {
            throw new Exception("Студент $studentId не найден");
        }

        try {
            DB::beginTransaction();

            $exam = Exam::create($data);

            DB::commit();
        }
        catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return Read::byId($studentId, (string) $exam->id);
    }
}
