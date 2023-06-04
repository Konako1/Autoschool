<?php

namespace App\Components\Students\BusinessLayer;

use App\Common\Exceptions\DataBaseException;
use App\Common\Exceptions\KnownException;
use App\Common\Helpers\PaymentsValidator;
use App\Components\Groups\Models\Group;
use App\Components\Instructors\Models\Instructor;
use App\Components\Payments\Models\Payment;
use App\Components\Students\Models\Student;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class Create
{
    /**
     * @throws Exception
     */
    public static function one(array $data, string $groupId, string $instructor_id): array
    {
        $group = Group::find($groupId);
        if (!$group) {
            throw new DataBaseException("Группа с id $groupId не найдена");
        }

        $instructor = Instructor::find($instructor_id);
        if (!$instructor) {
            throw new DataBaseException("Инструктор с id $instructor_id не найден");
        }
        if (!$instructor->is_practician) {
            throw new KnownException("Инструктором по практике не может быть лектор");
        }

        if(!isset($data['payment_value']))
            throw new KnownException("Необходимо внести начальный платеж");

        try {
            DB::beginTransaction();

            $student = Student::create($data);

            $data['payment_value'] = PaymentsValidator::validate($student, $data['payment_value']);

            Payment::create([
                'value' => $data['payment_value'],
                'date' => Carbon::now(),
                'student_id' => $student->id,
            ]);

            DB::commit();
        }
        catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return Read::byId((string) $student->id, ['group' => $groupId]);
    }
}
