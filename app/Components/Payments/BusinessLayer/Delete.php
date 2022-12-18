<?php

namespace App\Components\Payments\BusinessLayer;

use App\Components\Payments\Models\Payment;
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
            throw new Exception("Студент $studentId не найден");
        }

        $payment = Payment::find($id);
        if (!$payment) {
            throw new Exception("Платеж $id не найден");
        }

        try {
            DB::beginTransaction();

            $payment->delete();

            DB::commit();
        }
        catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return Read::trashed($studentId, (string) $payment->id);
    }
}
