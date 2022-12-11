<?php

declare(strict_types = 1);

namespace App\Common\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class RecordsList
{
    /**
     * Request
     *
     * @var array
     */
    protected $params;

    /**
     * Запрос получающий все данные
     *
     * @var Builder
     */
    protected $baseQuery;

    public function __construct(Builder $query, array $params)
    {
        $this->baseQuery = $query;
        $this->params = $params;
    }

    /**
     *  Получение данных с учетом поиска, фильтрации, сортировки и пагинации.
     *
     *  @return Collection
     */
    public function getRecords(): Collection
    {
        $fsop = new FSOPQuery($this->baseQuery, $this->params);
        $query = $fsop->getQuery();

        return $query->get();
    }

    /**
     *  Подсчет количества записей, возвращаемых по базовому запросу с учетом фильтрации и поиска
     *  @return int - возвращает количество записей по базовому запросу
     */
    public function countTotal(): int
    {
        $fsop = new FSOPQuery($this->baseQuery, $this->params);
        $query = $fsop->getQuery(true, true, false, false);
        return $query->count();
    }
}
