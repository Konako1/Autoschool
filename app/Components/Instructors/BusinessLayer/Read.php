<?php

namespace App\Components\Instructors\BusinessLayer;

use App\Common\Services\RecordsList;
use App\Components\Instructors\Models\Instructor;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class Read
{
    private static function getBaseQuery(): Builder
    {
        return Instructor::query()
            ->leftJoin(
                'public.cars',
                'public.instructors.car_id',
                '=',
                'public.cars.id'
            )
            ->select(
                'public.instructors.id AS id',
                'job',
                'education',
                'certificate',
                'driver_certificate',
                'driver_certificate_category',
                'car_id',
                'public.instructors.name AS name',
                'surname',
                'patronymic',
                'photo_path',
                'phone',
                'public.cars.name AS car_name',
                'public.cars.reg_number AS car_reg_number',
            );
    }

    /**
     * Получить запись по id
     *
     * @param string $id - id записи
     *
     * @return array
     * @throws Exception
     */
    public static function byId(string $id): array
    {
        $record = self::getBaseQuery()
            ->find($id);

        // проверка: если запись не найдена
        if (!$record) {
            throw new Exception("id $id не существует."); //DataBaseException(Error::getMessage(2002, "id", $id));
        }

        return $record->toArray();
    }

    /**
     * Получить список всех записей
     *
     * @param $params
     *
     * @return Collection
     */
    public static function all($params): Collection
    {
        $query = new RecordsList(self::getBaseQuery(), $params);
        return $query->getRecords();
    }

    /**
     * @param $params
     *
     * @return int
     */
    public static function count($params): int
    {
        $query = new RecordsList(self::getBaseQuery(), $params);
        return $query->countTotal();
    }

    /**
     * Получить удаленную запись по id
     *
     * @param string $id
     *
     * @return array
     */
    public static function trashed(string $id): array
    {
        return self::getBaseQuery()
            ->withTrashed()
            ->find($id)
            ->toArray()
        ;
    }
}