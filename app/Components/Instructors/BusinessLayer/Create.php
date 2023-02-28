<?php

namespace App\Components\Instructors\BusinessLayer;

use App\Components\Cars\Models\Car;
use App\Components\Instructors\Models\Instructor;
use Exception;
use Illuminate\Support\Facades\DB;

class Create
{
    /**
     * @throws Exception
     */
    public static function one(array $data, string $carId): array
    {
        $car = Car::find($carId);
        if (!$car) {
            throw new Exception("Машина $carId не найдена");
        }

        $instructor = Instructor::where('car_id', '=', $carId)->first();
        if ($instructor) {
            throw new Exception("Машина $carId уже занята");
        }

        try {
            DB::beginTransaction();

            $instructor = Instructor::create($data);

            DB::commit();
        }
        catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return Read::byId((string) $instructor->id);
    }
}
