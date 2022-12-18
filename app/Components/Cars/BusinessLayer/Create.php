<?php

namespace App\Components\Cars\BusinessLayer;

use App\Components\Cars\Models\Car;
use Exception;
use Illuminate\Support\Facades\DB;

class Create
{
    /**
     * @throws Exception
     */
    public static function one(array $data): array
    {
        try {
            DB::beginTransaction();

            $car = Car::create($data);

            DB::commit();
        }
        catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return Read::byId((string) $car->id);
    }
}
