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
    private static function getBaseQuery(array $filters = null): Builder
    {
        $query = Lesson::query()
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

        if (!isset($filters))
            return $query;

        if (isset($filters['group_id']))
            $query = $query->where('group_id', $filters['group_id']);

        if (isset($filters['module_id']))
            $query = $query->where('module_id', $filters['module_id']);

        if(isset($filters['exam']) && $filters['exam'] == 'true')
            $query = $query->where('public.modules.metadata', '=', 'exam');
        if(isset($filters['exam']) && $filters['exam'] == 'false')
            $query = $query->where('public.modules.metadata', '=', 'module');

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
     * @param      $params
     * @param array|null $filters
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
     * @param array|null $filters
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
