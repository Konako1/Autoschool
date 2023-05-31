<?php

namespace App\Components\Instructors\BusinessLayer;

use App\Common\Exceptions\DataBaseException;
use App\Components\Cars\Models\Car;
use App\Components\Categories\Models\Category;
use App\Components\Instructors\Models\Instructor;
use Exception;
use Illuminate\Support\Facades\DB;

class Create
{
    /**
     * @throws Exception
     */
    public static function one(array $data, string $carId, string $categoryId, string $is_practician): array
    {
        $category = Category::find($categoryId);
        if (!$category) {
            throw new DataBaseException("Категория с id $categoryId не найдена");
        }

        // у лекторов не может быть машины тк они не занимаются вождением
        if ($is_practician) {
            $car = Car::find($carId);
            if (!$car) {
                throw new DataBaseException("Машина с id $carId не найдена");
            }
            $instructor = Instructor::where('car_id', '=', $carId)->first();
            if ($instructor) {
                throw new DataBaseException("Машина с id $carId уже занята");
            }
        }
        else {
            $data['car_id'] = null;
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
