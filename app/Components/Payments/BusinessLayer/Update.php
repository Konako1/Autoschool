<?php

namespace App\Components\Payments\BusinessLayer;

use App\Common\Exceptions\DataBaseException;
use App\Components\Payments\Models\Payment;
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
            throw new DataBaseException("Студент с id $studentId не найден");
        }

        $payment = Payment::find($id);
        if (!$payment) {
            throw new DataBaseException("Платеж с id $id не найдена");
        }

        try {
            DB::beginTransaction();

            $payment->update($data);

            DB::commit();
        }
        catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return Read::byId($studentId, (string) $payment->id);
    }
}
