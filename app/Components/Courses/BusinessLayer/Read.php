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
    private static function getBaseQuery(): Builder
    {
        return Course::query()
            ->leftJoin(
                'public.course_modules',
                'public.courses.id',
                '=',
                'public.course_modules.course_id'
            )
            ->select(
                'courses.id as id',
                'name',
                'category',
                'price'
            )
            ->with(
                'modules'
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
