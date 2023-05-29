<?php

namespace App\Components\Cars\BusinessLayer;

use App\Common\Exceptions\KnownException;
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
        // TODO проверка на категорию машины (какой то категории не нужен гирбокс)
        if (!($data['gearbox_type'] == 'auto' or $data['gearbox_type'] == 'manual')) {
            throw new KnownException('Тип управления может быть только \'auto\' или \'manual\'');
        }

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
