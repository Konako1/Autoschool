<?php

namespace App\Components\Students\BusinessLayer;

use App\Common\Exceptions\DataBaseException;
use App\Common\Services\RecordsList;
use App\Components\Students\Models\Student;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class Read
{
    private static function getBaseQuery(array $filter = null): Builder
    {
        $query =  Student::query()
            ->leftJoin(
                'public.groups',
                'public.students.group_id',
                '=',
                'public.groups.id'
            )
            ->leftJoin(
                'public.timings',
                'public.groups.timing_id',
                '=',
                'public.timings.id'
            )
            ->leftJoin(
                'public.instructors',
                'public.students.instructor_id',
                '=',
                'public.instructors.id'
            )
            ->leftJoin(
                'public.courses',
                'public.groups.course_id',
                '=',
                'public.courses.id'
            )
            ->leftJoin(
                'public.categories',
                'public.courses.category_id',
                '=',
                'public.categories.id'
            )
            ->leftJoin(
                'public.cars',
                'public.instructors.car_id',
                '=',
                'public.cars.id'
            )
            ->select(
                'public.students.id AS id',
                'public.students.name AS name',
                'public.students.surname AS surname',
                'public.students.patronymic AS patronymic',
                'birthday',
                'public.students.photo_path AS photo_path',
                'public.students.phone AS phone',
                'address',
                'group_id',
                'public.groups.name AS group_name',
                'public.groups.studying_start_date as group_studying_start_date',
                'public.groups.studying_end_date as group_studying_end_date',
                'timing_id',
                'public.timings.start AS timing_start',
                'public.timings.end AS timing_end',
                'public.timings.time_interval AS timing_time_interval',
                'public.timings.type AS timing_type',
                'course_id',
                'public.courses.name as course_name',
                'public.courses.price as course_price',
                'public.courses.driving_hours as course_driving_hours',
                'public.courses.category_id as category_id',
                'public.categories.name AS category_name',
                'public.categories.description AS category_description',
                'public.courses.instructor_id AS course_instructor_id',
                'public.instructors.id AS instructor_id',
                'public.instructors.job AS instructor_job',
                'public.instructors.education AS instructor_education',
                'public.instructors.certificate AS instructor_certificate',
                'public.instructors.driver_certificate AS instructor_driver_certificate',
                'public.instructors.name AS instructor_name',
                'public.instructors.surname AS instructor_surname',
                'public.instructors.patronymic AS instructor_patronymic',
                'public.instructors.photo_path AS instructor_photo_path',
                'public.instructors.phone AS instructor_phone',
                'public.instructors.is_practician AS instructor_is_practician',
                'public.instructors.car_id AS car_id',
                'public.cars.name AS car_name',
                'public.cars.reg_number AS car_reg_number',
                'public.cars.gearbox_type AS car_gearbox_type',
            )
            ->with(
                'payments'
            )
            ->orderByDesc(
                'public.students.updated_at'
            );

        if (!isset($filter))
            return $query;

        if (key_exists('group', $filter))
            $query = $query->where('group_id', $filter['group']);

        if (key_exists('fio', $filter))
            $query = $query
                ->whereRaw(
                    "concat(".
                    "public.students.name,' ',public.students.surname,' ',public.students.patronymic, ' ',".
                    "public.students.name,' ',public.students.patronymic,' ',public.students.surname, ' ',".
                    "public.students.surname,' ',public.students.name,' ',public.students.patronymic, ' ',".
                    "public.students.surname,' ',public.students.patronymic,' ',public.students.name, ' ',".
                    "public.students.patronymic,' ',public.students.surname,' ',public.students.name, ' ',".
                    "public.students.patronymic,' ',public.students.name,' ',public.students.surname".
                    ") like ?",
                    "%{$filter['fio']}%"
                );

        return $query;
    }

    /**
     * Получить запись по id
     *
     * @param string $id - id записи
     * @param array|null $filters
     * @return array
     * @throws DataBaseException
     */
    public static function byId(string $id, array $filters = null): array
    {
        $record = self::getBaseQuery($filters)
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
     * @param array|null $filters
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
     * @param string $groupId
     * @param string $id
     *
     * @return array
     */
    public static function trashed(string $groupId, string $id): array
    {
        return self::getBaseQuery(['group_id' => $groupId])
            ->withTrashed()
            ->find($id)
            ->toArray()
        ;
    }
}
