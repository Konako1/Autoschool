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
    private static function getBaseQuery(array $filter = null): Builder
    {
        $query = Group::query()
            ->leftJoin(
                'public.courses',
                'public.groups.course_id',
                '=',
                'public.courses.id'
            )
            ->leftJoin(
                'public.timings',
                'public.groups.timing_id',
                '=',
                'public.timings.id'
            )
            ->leftJoin(
                'public.categories',
                'public.courses.category_id',
                '=',
                'public.categories.id'
            )
            ->select(
                'public.groups.id AS id',
                'public.groups.name AS name',
                'studying_start_date',
                'studying_end_date',
                'course_id',
                'public.courses.name AS course_name',
                'public.courses.price AS course_price',
                'public.courses.driving_hours AS course_driving_hours',
                'public.courses.category_id AS category_id',
                'public.categories.name AS category_name',
                'public.categories.description AS category_description',
                'public.courses.instructor_id AS course_instructor_id',
                'timing_id',
                'public.timings.start AS timing_start',
                'public.timings.end AS timing_end',
                'public.timings.time_interval AS timing_time_interval',
                'public.timings.type AS timing_type',
            )
            ->with(
                'weekdays'
            )
            ->orderByDesc(
                'public.groups.updated_at'
            );
        if (!isset($filter))
            return $query;

        if (key_exists('category_id', $filter))
            $query = $query->where('category_id', '=', $filter['category_id']);

        if (key_exists('timing_type', $filter))
            $query = $query->where('public.timings.type', 'like', $filter['timing_type']);

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
