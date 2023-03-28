<?php

namespace App\Components\Groups\BusinessLayer;

use App\Common\Exceptions\DataBaseException;
use App\Common\Services\RecordsList;
use App\Components\Groups\Models\Group;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class Read
{
    private static function getBaseQuery(): Builder
    {
        return Group::query()
            ->leftJoin(
                'public.instructors',
                'public.groups.instructor_id',
                '=',
                'public.instructors.id'
            )
            ->leftJoin(
                'public.courses',
                'public.groups.course_id',
                '=',
                'public.courses.id'
            )
            ->select(
                'public.groups.id AS id',
                'public.groups.name AS name',
                'studying_start_date',
                'studying_end_date',
                'examen_date',
                'instructor_id',
                'public.instructors.job AS instructor_job',
                'public.instructors.education AS instructor_education',
                'public.instructors.certificate AS instructor_certificate',
                'public.instructors.driver_certificate AS instructor_driver_certificate',
                'public.instructors.driver_certificate_category AS instructor_driver_certificate_category',
                'public.instructors.car_id AS instructor_car_id',
                'public.instructors.name AS instructor_name',
                'public.instructors.surname AS instructor_surname',
                'public.instructors.patronymic AS instructor_patronymic',
                'public.instructors.photo_path AS instructor_photo_path',
                'public.instructors.phone AS instructor_phone',
                'public.instructors.is_practician AS instructor_is_practician',
                'course_id',
                'public.courses.name AS course_name',
                'public.courses.category AS course_category',
                'public.courses.price AS course_price',
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
    public static function trashed( string $id): array
    {
        return self::getBaseQuery()
            ->withTrashed()
            ->find($id)
            ->toArray()
        ;
    }
}
