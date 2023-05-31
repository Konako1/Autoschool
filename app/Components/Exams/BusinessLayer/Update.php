<?php

namespace App\Components\Exams\BusinessLayer;

use App\Common\Exceptions\DataBaseException;
use App\Components\Exams\Models\Exam;
use App\Components\Modules\Models\Module;
use App\Components\Students\Models\Student;
use Exception;
use Illuminate\Support\Facades\DB;

class Update
{
    /**
     * @throws Exception
     */
    public static function one(array $data, string $id, string $studentId, string $moduleId): array
    {
        $student = Student::find($studentId);
        if (!$student) {
            throw new DataBaseException("Студент с id $studentId не найден");
        }

        $exam = Exam::find($id);
        if (!$exam) {
            throw new DataBaseException("Экзамен с id $id не найден");
        }

        $module = Module::find($moduleId);
        if (!$module && $module->metadata != 'exam'){
            throw new DataBaseException("Модуль с id $moduleId не является экзаменом.");
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
