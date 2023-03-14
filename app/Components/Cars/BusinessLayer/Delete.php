<?php

namespace App\Components\Cars\BusinessLayer;

use App\Common\Exceptions\DataBaseException;
use App\Components\Cars\Models\Car;
use App\Components\Students\Models\Student;
use Exception;
use Illuminate\Support\Facades\DB;

class Delete
{
    /**
     * @throws Exception
     */
    public static function one(string $id): array
    {
        $car = Car::find($id);
        if (!$car) {
            throw new DataBaseException("Машина с id $id не найдена");
        }

        try {
            DB::beginTransaction();

            $car->delete();

            DB::commit();
        }
        catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return Read::trashed((string) $car->id);
    }
}
