<?php

namespace App\Components\Instructors\BusinessLayer;

use App\Common\Exceptions\DataBaseException;
use App\Common\Services\RecordsList;
use App\Components\Instructors\Models\Instructor;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class Read
{
    private static function getBaseQuery($params = null): Builder
    {
        $query = Instructor::query()
            ->leftJoin(
                'public.cars',
                'public.instructors.car_id',
                '=',
                'public.cars.id'
            )
            ->leftJoin(
                'public.categories',
                'public.instructors.category_id',
                '=',
                'public.categories.id'
            )
            ->select(
                'public.instructors.id AS id',
                'job',
                'education',
                'certificate',
                'driver_certificate',
                'is_practician',
                'public.instructors.name AS name',
                'surname',
                'patronymic',
                'photo_path',
                'phone',
                'public.instructors.category_id AS category_id',
                'public.categories.name AS category_name',
                'public.categories.description AS category_description',
                'car_id',
                'public.cars.name AS car_name',
                'public.cars.reg_number AS car_reg_number',
                'public.cars.gearbox_type AS car_gearbox_type',
            )
            ->orderByDesc(
                'public.instructors.updated_at'
            );

        if (isset($params['filter']['is_practician'])) {
            $query->where('is_practician', '=', $params['filter']['is_practician']);
        }
        if (isset($params['filter']['category_id'])) {
            $query->where('public.instructors.category_id', '=', $params['filter']['category_id']);
        }
        return $query;
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
            throw new DataBaseException("id $id не существует."); //DataBaseException(Error::getMessage(2002, "id", $id));
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
        $query = new RecordsList(self::getBaseQuery($params), $params);
        return $query->getRecords();
    }

    /**
     * @param $params
     *
     * @return int
     */
    public static function count($params): int
    {
        $query = new RecordsList(self::getBaseQuery($params), $params);
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
