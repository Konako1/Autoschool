<?php

namespace App\Components\Payments\BusinessLayer;

use App\Common\Exceptions\DataBaseException;
use App\Common\Exceptions\KnownException;
use App\Components\Payments\Models\Payment;
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
            throw new DataBaseException("Студент с id $studentId не найден");
        }

        if ($data['value'] <= 0) {
            throw new KnownException("Значение оплаты должно быть больше нуля.");
        }

        $paymentsSum = Payment::where('student_id', '=', $studentId)->get()->sum('value');
        $coursePrice = $student->group()->course()->price;
        if ($paymentsSum + $data['value'] > $coursePrice) {
            $overpay = $paymentsSum + $data['value'] - $coursePrice;
            $finalPaymentNeeded = $coursePrice - $paymentsSum;
            if ($finalPaymentNeeded == 0)
                throw new KnownException("Курс полностью оплачен.");
            throw new KnownException("Оплата курса превышена на {$overpay}р. Внесите {$finalPaymentNeeded}р для полной оплаты.");
        }

        try {
            DB::beginTransaction();

            $payment = Payment::create($data);

            DB::commit();
        }
        catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return Read::byId($studentId, (string) $payment->id);
    }
}
