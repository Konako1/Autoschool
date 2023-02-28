<?php

namespace App\Components\Lessons\BusinessLayer;

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
            ->select(
                'public.lessons.id AS id',
                'time_start',
                'time_end',
                'module_id',
                'group_id',
                'public.groups.name AS group_name',
                'public.groups.studying_start_date AS group_studying_start_date',
                'public.groups.studying_end_date AS group_studying_end_date',
                'public.groups.examen_date AS group_examen_date',
                'public.groups.instructor_id AS group_instructor_id',
                'public.modules.name AS module_name',
                'public.modules.description AS module_description',
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
    private static function getBaseQueryByModuleAndGroupId(string $moduleId = null, string $groupId = null): Builder
    {
        $query = self::getBaseQuery();
        if (isset($moduleId))
            $query = $query->where('module_id', $moduleId);
        if (isset($groupId))
            $query = $query->where('group_id', $groupId);

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
            throw new Exception("id $id не существует."); //DataBaseException(Error::getMessage(2002, "id", $id));
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
     * @param $moduleId
     * @param $params
     *
     * @return Collection
     */
    public static function allByGroupAndModuleId($groupId, $moduleId, $params): Collection
    {
        $query = new RecordsList(self::getBaseQueryByModuleAndGroupId($moduleId, $groupId), $params);
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
     *
     * @return int
     */
    public static function count($params, $groupId = null, $moduleId = null): int
    {
        $query = new RecordsList(self::getBaseQueryByModuleAndGroupId($moduleId, $groupId), $params);
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
