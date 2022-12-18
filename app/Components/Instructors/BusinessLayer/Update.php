<?php

namespace App\Components\Instructors\BusinessLayer;

use App\Components\Cars\Models\Car;
use App\Components\Instructors\Models\Instructor;
use Exception;
use Illuminate\Support\Facades\DB;

class Update
{
    /**
     * @throws Exception
     */
    public static function one(array $data, string $id, string $carId): array
    {
        $car = Car::find($carId);
        if (!$car) {
            throw new Exception("Машина $carId не найдена");
        }

        $instructor = Instructor::where('car_id', '=', $carId)->first();
        if ($instructor) {
            throw new Exception("Машина $carId уже занята");
        }

        $instructor = Instructor::find($id);
        if (!$instructor) {
            throw new Exception("Инструктор $id не найден");
        }

        try {
            DB::beginTransaction();

            $instructor->update($data);

            DB::commit();
        }
        catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return Read::byId((string) $instructor->id);
    }
}
