<?php

namespace App\Components\Courses\Controllers;

use App\Common\Resources\SuccessResource;
use App\Common\Resources\SuccessResourceCollection;
use App\Common\Services\BaseCrudController;
use App\Components\Courses\BusinessLayer\Create;
use App\Components\Courses\BusinessLayer\Delete;
use App\Components\Courses\BusinessLayer\Read;
use App\Components\Courses\BusinessLayer\Update;
use Exception;
use Illuminate\Http\Request;

class CourseController extends BaseCrudController
{
    /**
     * Фильтрация запроса на получение
     * @param Request $request
     *
     * @return SuccessResourceCollection|Exception
     */
    public function baseGet(Request $request)
    {
        try {
            $params = $this->getParams($request);
            $filters = $request->query();
            $result = $this->getAllRecords($params, $filters['filter'] ?? null);
        }
        catch (Exception $e) {
            $result = $this->errorFromException($e, 'Ошибка получения записей');
        }

        return $result;
    }

    /**
     * Получение списка записей
     * GET /api/courses/
     *
     */
    public function getAllRecords(array $params, array $filters)
    {
        try {
            $records    = Read::all($params, $filters);
            $total      = Read::count($params, $filters);
            $result     = new SuccessResourceCollection($records->toArray(), $total);
        }
        catch (Exception $e) {
            $result = $this->errorFromException($e, 'Ошибка получения записей');
        }

        return $result;
    }

    /**
     * Получение записи
     * GET /api/courses/one?id={id}
     *
     */
    public function getRecord(Request $request)
    {
        try {
            $params = $request->query();
            $records    = Read::byId($params['id']);
            $result     = new SuccessResource($records);
        }
        catch (Exception $e) {
            $result = $this->errorFromException($e, 'Ошибка получения записи');
        }

        return $result;
    }

    /**
     * Создание одной записи
     * POST /api/courses/create?name={}&studying_start_date={}&studying_end_date={}&examen_date={}&instructor_id={}
     *
     */
    public function createRecord(Request $request)
    {
        try {
            $params = $request->query();
            $record = Create::one($params, $params['instructor_id'], $params['category_id']);
            $result = new SuccessResource($record);
        }
        catch(Exception $e) {
            $result = $this->errorFromException($e, 'Ошибка создания записи');
        }

        return $result;
    }

    /**
     * Обновление одной записи
     * POST /api/courses/update?id={}&name={}&studying_start_date={}&studying_end_date={}&examen_date={}&instructor_id={}
     *
     */
    public function updateRecord(Request $request)
    {
        try {
            $params = $request->query();
            $record = Update::one($params, $params['id'], $params['instructor_id'], $params['category_id']);
            $result = new SuccessResource($record);
        }
        catch(Exception $e) {
            $result = $this->errorFromException($e, 'Ошибка обновления записи');
        }

        return $result;
    }

    /**
     * Удаление одной записи
     * POST /api/courses/delete?id={}
     *
     */
    public function deleteRecord(Request $request)
    {
        try {
            $params = $request->query();
            $record = Delete::one($params['id']);
            $result = new SuccessResource($record);
        }
        catch(Exception $e) {
            $result = $this->errorFromException($e, 'Ошибка удаления записи');
        }

        return $result;
    }
}
