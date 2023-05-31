<?php

namespace App\Components\Lessons\BusinessLayer;

use App\Common\Exceptions\DataBaseException;
use App\Common\Services\RecordsList;
use App\Components\Lessons\Models\Lesson;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class Read
{
    private static function getBaseQuery(): Builder
    {
        return Lesson::query()
            ->leftJoin(
                'public.groups',
                'public.lessons.group_id',
                '=',
                'public.groups.id'
            )
            ->leftJoin(
                'public.modules',
                'public.lessons.module_id',
                '=',
                'public.modules.id'
            )
            ->leftJoin(
                'public.timings',
                'public.groups.timing_id',
                '=',
                'public.timings.id'
            )
            ->select(
                'public.lessons.id AS id',
                'title',
                'date',
                'module_id',
                'group_id',
                'moved_date',
                'moved_time',
                'public.groups.name AS group_name',
                'public.groups.studying_start_date AS group_studying_start_date',
                'public.groups.studying_end_date AS group_studying_end_date',
                'public.groups.examen_date AS group_examen_date',
                'public.groups.course_id AS course_id',
                'public.groups.timing_id AS timing_id',
                'public.timings.start AS timing_start',
                'public.timings.end AS timing_end',
                'public.timings.time_interval AS timing_time_interval',
                'public.timings.type AS timing_type',
                'public.modules.name AS module_name',
                'public.modules.description AS module_description',
                'public.modules.hours AS module_hours',
                'public.modules.metadata AS module_metadata',
            );
    }

    /**
     * Базовый запрос по id модуля и id группы
     *
     * @param string|null $moduleId
     * @param string|null $groupId
     *
     * @return Builder
     */
    private static function getBaseQueryByModuleAndGroupId(string $moduleId = null, string $groupId = null, bool $exam = false): Builder
    {
        $query = self::getBaseQuery();
        if (isset($moduleId))
            $query = $query->where('module_id', $moduleId);
        if (isset($groupId))
            $query = $query->where('group_id', $groupId);
        if ($exam)
            $query = $query->where('modules.metadata', '=', 'exam');

        return $query;
    }

    /**
     * Получить запись по id
     *
     * @param string $moduleId - id модуля
     * @param string $groupId  - id группы
     * @param string $id       - id записи
     *
     * @return array
     * @throws Exception
     */
    public static function byId(string $moduleId, string $groupId, string $id): array
    {
        $record = self::getBaseQueryByModuleAndGroupId($moduleId, $groupId)
            ->find($id);

        // проверка: если запись не найдена
        if (!$record) {
            throw new DataBaseException("id $id не существует.");
        }

        return $record->toArray();
    }

    /**
     * Получить список всех записей по модулю
     *
     * @param $moduleId
     * @param $params
     *
     * @return Collection
     */
    public static function allByModuleId($moduleId, $params): Collection
    {
        $query = new RecordsList(self::getBaseQueryByModuleAndGroupId($moduleId), $params);
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
        $query = new RecordsList(self::getBaseQueryByModuleAndGroupId(null, $groupId), $params);
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
    public static function allExamsByGroupId($groupId, $params): Collection
    {
        $query = new RecordsList(self::getBaseQueryByModuleAndGroupId(null, $groupId, true), $params);
        return $query->getRecords();
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
     * @param      $params
     * @param null $groupId
     * @param null $moduleId
     * @param bool $exam
     * @return int
     */
    public static function count($params, $groupId = null, $moduleId = null, bool $exam = false): int
    {
        $query = new RecordsList(self::getBaseQueryByModuleAndGroupId($moduleId, $groupId, $exam), $params);
        return $query->countTotal();
    }

    /**
     * Получить удаленную запись по id
     *
     * @param string $moduleId
     * @param string $groupId
     * @param string $id
     *
     * @return array
     */
    public static function trashed(string $moduleId, string $groupId, string $id): array
    {
        return self::getBaseQueryByModuleAndGroupId($moduleId, $groupId)
            ->withTrashed()
            ->find($id)
            ->toArray()
        ;
    }
}
