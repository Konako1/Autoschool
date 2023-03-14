<?php

namespace App\Components\Instructors\BusinessLayer;

use App\Common\Exceptions\DataBaseException;
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
            throw new DataBaseException("Машина с id $carId не найдена");
        }

        $instructor = Instructor::where('car_id', '=', $carId)->first();
        if ($instructor) {
            throw new DataBaseException("Машина с id $carId уже занята");
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
