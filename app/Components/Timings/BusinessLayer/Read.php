<?php

namespace App\Components\Timings\BusinessLayer;

use App\Common\Exceptions\DataBaseException;
use App\Common\Services\RecordsList;
use App\Components\Timings\Models\Timing;

class Read
{
    private static function getBaseQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return Timing::query()
            ->select(
                'id',
                'start',
                'end',
                'time_interval',
                'type',
            )
            ->orderByDesc(
                'public.timings.updated_at'
            );
    }

    /**
     * Получить список всех записей
     *
     * @param $params
     *
     * @return \Illuminate\Support\Collection
     */
    public static function all($params): \Illuminate\Support\Collection
    {
        $query = new RecordsList(self::getBaseQuery(), $params);
        return $query->getRecords();
    }

    /**
     * Получить запись по id
     *
     * @param string $id - id записи
     *
     * @return array
     * @throws DataBaseException
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
    public static function trashed(string $id): array
    {
        return self::getBaseQuery()
            ->withTrashed()
            ->find($id)
            ->toArray()
            ;
    }
}
