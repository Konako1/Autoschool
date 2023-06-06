<?php

namespace App\Components\Instructors\BusinessLayer;

use App\Common\Exceptions\DataBaseException;
use App\Common\Exceptions\KnownException;
use App\Components\Cars\Models\Car;
use App\Components\Categories\Models\Category;
use App\Components\Instructors\Models\Instructor;
use Exception;
use Illuminate\Support\Facades\DB;

class Update
{
    /**
     * @throws Exception
     */
    public static function one(array $data, string $id, string $categoryId, string $is_practician): array
    {
        $instructor = Instructor::find($id);
        if (!$instructor) {
            throw new DataBaseException("Инструктор с id $id не найден");
        }

        $category = Category::find($categoryId);
        if (!$category) {
            throw new DataBaseException("Категория с id $categoryId не найдена");
        }

        // у лекторов не может быть машины тк они не занимаются вождением
        if ($is_practician) {
            $carId = $data['car_id'] ?? null;
            if (!isset($carId))
                throw new KnownException("Необходимо передавать id машины вместе с инструктором");

            $car = Car::find($carId);
            if (!$car) {
                throw new DataBaseException("Машина с id $carId не найдена");
            }
            $instructorWithCar = Instructor::where('car_id', '=', $carId)->first();
            if ($instructorWithCar && $instructorWithCar->id != $instructor->id) {
                throw new DataBaseException("Машина с id $carId уже занята");
            }
        }
        else {
            $data['car_id'] = null;
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
