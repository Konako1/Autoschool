<?php

declare(strict_types = 1);

/**
 * @class
 * Filter - search - order - paginate
 * Класс для работы со списками данных на уровне DB
 * Позволяет добавлять в базовый запрос функции фильтрации, поиска, сортировки и пагинации
 */

namespace App\Common\Services;

use Illuminate\Database\Eloquent\Builder;

class FSOPQuery
{
    const VALID_OPERATORS = [
        'GREATER_THAN' => '>',
        'LESS_THAN' => '<',
        'GREATER_THAN_EQUAL' => '>=',
        'LESS_THAN_EQUAL' => '<=',
        'EQUAL' => '=',
        'NOT_EQUAL' => '<>',
        'LIKE' => 'LIKE',
        'ILIKE' => 'ILIKE',
        'IN' => '',
        'FIELD_IS_NULL' => '',
        'FIELD_IS_NOT_NULL' => '',
    ];

    const MAX_RECORDS_PER_PAGE = 200;
    /**
     * Filters
     * Параметры фильтрации
     *
     * @var array
     */
    private $filters;

    /**
     * Search
     * Параметры поиска
     *
     * @var array
     */
    private $search;

    /**
     * Orders
     * Параметры сортировки
     *
     * @var array
     */
    private $orders;

    /**
     * Paginate
     * Параметры пагинации - текущая страница
     *
     * @var int currentPage
     */
    private $currentPage;

    /**
     * Paginate
     * Параметры пагинации - количество записей на страницу
     *
     * @var int $recordsPerPage
     */
    private $recordsPerPage;

    /**
     * Запрос
     *
     * @var Builder
     */
    private $query;

    public function __construct(Builder $query, array $params)
    {
        $filters = (isset($params['filters']) && is_array($params['filters'])) ? $params['filters'] : [];
        $this->filters = [];

        foreach ($filters as $filter) {
            $fieldname = $filter['fieldname'] ?? '';
            $operator = $filter['operator'] ?? '';

            if(!($fieldname && $operator)) {
                continue;
            }

            if (!key_exists($operator, self::VALID_OPERATORS)) {
                continue;
            }

            $this->filters[] = $filter;
        }

        $this->search = [];
        $search = $params['search'] ?? '';

        if (is_array($search)) {
            $searchStr = isset($search['searchStr']) ? '%' . $search['searchStr'] . '%' : '';
            $columns = $search['searchFields'] ?? [];

            if ($searchStr && count($columns)>0) {
                $this->search['searchStr'] = $searchStr;
                $this->search['searchFields'] = $columns;
            }
        }

        $this->orders = $params['orders'] ?? [];

        $curPage = $params['page'];
        $this->currentPage = is_numeric($curPage) ? $curPage : 1;

        $perPage = is_numeric($params['limit']) ? (int) $params['limit'] : self::MAX_RECORDS_PER_PAGE;
        $this->recordsPerPage = $perPage <= self::MAX_RECORDS_PER_PAGE ? $perPage : self::MAX_RECORDS_PER_PAGE;

        $this->query = clone $query;
    }

    /**
     * Добавляет фильтрацию к запросу
     *
     * @return void
     */
    private function appendFilters()
    {
        if (!empty($this->filters)) {
            $filters = $this->filters;
            $this->query->where(function ($query) use ($filters) {
                foreach ($filters as $filter) {
                    $operator = $filter['operator'] ?? '';
                    $fieldName = $filter['fieldname'] ?? '';
                    $value = $filter['value'] ?? '';

                    switch ($operator) {
                        case 'FIELD_IS_NULL':
                        {
                            $this->query->whereNull($fieldName);
                            break;
                        }

                        case 'FIELD_IS_NOT_NULL':
                        {
                            $this->query->whereNotNull($fieldName);
                            break;
                        }

                        case 'IN':
                        {
                            $values = is_array($value) ? $value:[$value];
                            $this->query->whereIn($fieldName, $values);
                            break;
                        }

                        default :
                        {
                            if ($operator==='LIKE' || $operator==='ILIKE') {
                                $value = "%$value%";
                            }
                            $this->query->where($fieldName, self::VALID_OPERATORS[$operator], $value);
                        }
                    }
                }
            });
        }
    }

    /**
     * Добавляет параметры поиска к запросу
     *
     * @return void
     */
    private function appendSearch()
    {
        if (!empty($this->search)) {
            $searchStr = $this->search['searchStr'];
            $columns = $this->search['searchFields'];

            $this->query->where(function ($query) use ($searchStr, $columns) {
                foreach ($columns as $column) {
                    $query->orWhere($column, 'ILIKE', $searchStr);
                }
            });
        }
    }

    /**
     * Добавляет сортировку к запросу
     *
     * @return void
     */
    private function appendOrders()
    {
        foreach ($this->orders as $order) {
            if (isset($order['fieldname']) && isset($order['direction'])) {
                $this->query->orderBy($order['fieldname'], $order['direction']);
            }
        }
    }

    /**
     * Добавляет пагинацию к запросу
     *
     * @return void
     */
    private function paginate()
    {
        if (is_numeric($this->currentPage) && ($this->currentPage > 0) &&
            is_numeric($this->recordsPerPage) && ($this->recordsPerPage > 0)) {
            $this->query->skip(($this->currentPage-1)*$this->recordsPerPage)->take($this->recordsPerPage);
        }
    }

    /**
     * Построение запроса с учетом поиска, фильтрации, сортировки и пагинации.
     *  @param bool $withFilter - c фильтрацией
     *  @param bool $withOrder - c сортировкой
     *  @param bool $withSearch - c поиском
     *  @param bool $paginate - c пагинацией
     *
     *  @return Builder
     */
    public function getQuery($withFilter = true, $withSearch = true, $withOrder = true, $paginate = true): Builder
    {
        if ($withFilter) {
            $this->appendFilters();
        }

        if ($withSearch) {
            $this->appendSearch();
        }

        if ($withOrder) {
            $this->appendOrders();
        }

        if ($paginate) {
            $this->paginate();
        }

        return $this->query;
    }

}
