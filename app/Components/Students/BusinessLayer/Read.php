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
            ->select(
                'public.students.id AS id',
                'public.students.name AS name',
                'public.students.surname AS surname',
                'public.students.patronymic AS patronymic',
                'birthday',
                'public.students.photo_path AS photo_path',
                'public.students.phone AS phone',
                'address',
                'gearbox_type',
                'group_id',
                'public.groups.name AS group_name',
                'public.groups.studying_start_date as group_studying_start_date',
                'public.groups.studying_end_date as group_studying_end_date',
                'public.groups.examen_date as group_examen_date',
                'course_id',
                'public.courses.name as course_name',
                'public.courses.category as course_category',
                'public.courses.price as course_price',
                'public.courses.driving_hours as course_driving_hours',
                'public.instructors.id AS instructor_id',
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
                'public.instructors.is_practician AS instructor_is_practician'
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
