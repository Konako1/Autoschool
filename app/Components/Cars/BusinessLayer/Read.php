<?php

namespace App\Components\Cars\BusinessLayer;

use App\Common\Exceptions\DataBaseException;
use App\Common\Services\RecordsList;
use App\Components\Cars\Models\Car;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class Read
{
    private static function getBaseQuery(array $filters = null): Builder
    {
        $query = Car::query()
            ->leftJoin(
                'public.categories',
                'public.cars.category_id',
                '=',
                'public.categories.id'
            )
            ->leftJoin(
                'public.instructors',
                'public.instructors.car_id',
                '=',
                'public.cars.id'
            )
            ->select(
                'cars.id AS id',
                'cars.name AS car_name',
                'reg_number',
                'gearbox_type',
                'public.cars.category_id AS category_id',
                'categories.name AS category_name',
                'categories.description AS category_description',
                'public.instructors.id AS instructor_id',
                'public.instructors.job AS instructor_job',
                'public.instructors.education AS instructor_education',
                'public.instructors.certificate AS instructor_certificate',
                'public.instructors.driver_certificate AS instructor_driver_certificate',
                'public.instructors.is_practician AS instructor_is_practician',
                'public.instructors.name AS instructor_name',
                'public.instructors.surname AS instructor_surname',
                'public.instructors.patronymic AS instructor_patronymic',
                'public.instructors.photo_path AS instructor_photo_path',
                'public.instructors.phone AS instructor_phone',
            )
            ->orderByDesc(
                'cars.updated_at'
            );

        if (!isset($filters))
            return $query;

        if (isset($filters['free']) && $filters['free'])
            $query = $query->where('public.instructors.id', '=', null);

        if (isset($filters['taken']) && $filters['taken'])
            $query = $query->where('public.instructors.id', '!=', null);

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
            throw new DataBaseException("id $id не существует.");
        }

        return $record->toArray();
    }

    /**
     * Получить список всех записей
     *
     * @param $params
     * @param array $filters
     * @return Collection
     */
    public static function all($params, array $filters = null): Collection
    {
        $query = new RecordsList(self::getBaseQuery($filters), $params);
        return $query->getRecords();
    }

    /**
     * @param $params
     *
     * @return int
     */
    public static function count($params, array $filters = null): int
    {
        $query = new RecordsList(self::getBaseQuery($filters), $params);
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
