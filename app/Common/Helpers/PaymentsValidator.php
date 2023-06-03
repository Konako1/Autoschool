<?php

namespace App\Common\Helpers;

use App\Common\Exceptions\KnownException;
use App\Components\Payments\Models\Payment;
use App\Components\Students\Models\Student;

class PaymentsValidator
{
    /**
     * @throws KnownException
     */
    public static function validate(Student $student, float $value) {
        if ($value <= 0) {
            throw new KnownException("Значение оплаты должно быть больше нуля.");
        }

        $paymentsSum = Payment::where('student_id', '=', $student->id)->get()->sum('value');
        $coursePrice = $student->group()->course()->price;
        if ($paymentsSum + $value > $coursePrice) {
            $overpay = $paymentsSum + $value - $coursePrice;
            $finalPaymentNeeded = $coursePrice - $paymentsSum;
            if ($finalPaymentNeeded == 0)
                throw new KnownException("Курс полностью оплачен.");
            throw new KnownException("Оплата курса превышена на {$overpay}р. Внесите {$finalPaymentNeeded}р для полной оплаты.");
        }
    }
}
