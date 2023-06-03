<?php

namespace App\Components\Exams\BusinessLayer;

use App\Common\Exceptions\DataBaseException;
use App\Common\Exceptions\KnownException;
use App\Components\Exams\Models\Exam;
use App\Components\Modules\Models\Module;
use App\Components\Students\Models\Student;
use Exception;
use Illuminate\Support\Facades\DB;

class Create
{
    /**
     * @throws Exception
     */
    public static function one(array $data, string $studentId, string $moduleId): array
    {
        $student = Student::find($studentId);
        if (!$student) {
            throw new DataBaseException("Студент с id $studentId не найден");
        }

        $module = Module::find($moduleId);
        if ($module && $module->metadata != 'exam'){
            throw new KnownException("Модуль с id $moduleId не является экзаменом.");
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
