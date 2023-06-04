<?php

namespace App\Components\Courses\BusinessLayer;

use App\Common\Exceptions\DataBaseException;
use App\Common\Services\RecordsList;
use App\Components\Courses\Models\Course;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class Read
{
    private static function getBaseQuery(array $filters = null): Builder
    {
        $query = Course::query()
            ->leftJoin(
                'public.instructors',
                'public.courses.instructor_id',
                '=',
                'public.instructors.id'
            )
            ->leftJoin(
                'public.categories',
                'public.courses.category_id',
                '=',
                'public.categories.id'
            )
            ->select(
                'courses.id as id',
                'courses.name',
                'price',
                'driving_hours',
                'public.courses.category_id AS category_id',
                'categories.name AS category_name',
                'categories.description AS category_description',
                'instructor_id',
                'public.instructors.job AS instructor_job',
                'public.instructors.education AS instructor_education',
                'public.instructors.certificate AS instructor_certificate',
                'public.instructors.driver_certificate AS instructor_driver_certificate',
                'public.instructors.car_id AS instructor_car_id',
                'public.instructors.name AS instructor_name',
                'public.instructors.surname AS instructor_surname',
                'public.instructors.patronymic AS instructor_patronymic',
                'public.instructors.photo_path AS instructor_photo_path',
                'public.instructors.phone AS instructor_phone',
                'public.instructors.is_practician AS instructor_is_practician',
            )
            ->with(
                'modules'
            )
            ->orderByDesc(
                'public.courses.updated_at'
            );

        if (!isset($filters))
            return $query;

        if (isset($filters['category_id']))
            $query = $query->where('public.courses.category_id', '=', $filters['category_id']);

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
     *
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
    public static function trashed( string $id): array
    {
        return self::getBaseQuery()
            ->withTrashed()
            ->find($id)
            ->toArray()
        ;
    }
}
