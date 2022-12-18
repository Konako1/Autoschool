<?php

namespace App\Components\Cars\BusinessLayer;

use App\Components\Cars\Models\Car;
use Exception;
use Illuminate\Support\Facades\DB;

class Update
{
    /**
     * @throws Exception
     */
    public static function one(array $data, string $id): array
    {
        $car = Car::find($id);
        if (!$car) {
            throw new Exception("Машина $id не найдена");
        }

        try {
            DB::beginTransaction();

            $car->update($data);

            DB::commit();
        }
        catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return Read::byId((string) $car->id);
    }
}
