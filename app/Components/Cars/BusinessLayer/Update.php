<?php

namespace App\Components\Cars\BusinessLayer;

use App\Common\Exceptions\DataBaseException;
use App\Common\Exceptions\KnownException;
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
        // TODO проверка на категорию машины (какой то категории не нужен гирбокс)
        if (!($data['gearbox_type'] == 'auto' or $data['gearbox_type'] == 'manual')) {
            throw new KnownException('Тип управления может быть только \'auto\' или \'manual\'');
        }

        $car = Car::find($id);
        if (!$car) {
            throw new DataBaseException("Машина с id $id не найдена");
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
