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
    private static function getBaseQuery(): Builder
    {
        return Student::query()
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
                'public.groups.examen_date as group_examen_date',
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

    }

    /**
     * Базовый запрос по id группы
     *
     * @param string $groupId
     *
     * @return Builder
     */
    private static function getBaseQueryByGroupId(string $groupId): Builder
    {
        return self::getBaseQuery()
            ->where('group_id', $groupId);
    }

    /**
     * Получить запись по id
     *
     * @param string $groupId - id группы
     * @param string $id - id записи
     *
     * @return array
     * @throws Exception
     */
    public static function byId(string $groupId, string $id): array
    {
        $record = self::getBaseQueryByGroupId($groupId)
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
     * Получить список всех записей по группе
     *
     * @param $groupId
     * @param $params
     *
     * @return Collection
     */
    public static function allByGroupId($groupId, $params): Collection
    {
        $query = new RecordsList(self::getBaseQueryByGroupId($groupId), $params);
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
     * @param string $groupId
     * @param string $id
     *
     * @return array
     */
    public static function trashed(string $groupId, string $id): array
    {
        return self::getBaseQueryByGroupId($groupId)
            ->withTrashed()
            ->find($id)
            ->toArray()
        ;
    }
}
