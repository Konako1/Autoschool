<?php

namespace App\Components\Groups\Controllers;

use App\Common\Resources\SuccessResource;
use App\Common\Resources\SuccessResourceCollection;
use App\Common\Services\BaseCrudController;
use App\Components\Groups\BusinessLayer\Create;
use App\Components\Groups\BusinessLayer\Delete;
use App\Components\Groups\BusinessLayer\Read;
use App\Components\Groups\BusinessLayer\Update;
use App\Components\Groups\BusinessLayer\Validations\CalendarValidation;
use Exception;
use Illuminate\Http\Request;

class GroupController extends BaseCrudController
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
     * GET /api/groups/
     *
     */
    public function getAllRecords(array $params, array $filters = null)
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
     * GET /api/groups/one?id={id}
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
     * POST /api/groups/create?name={}&studying_start_date={}&studying_end_date={}&examen_date={}&instructor_id={}
     *
     */
    public function createRecord(Request $request)
    {
        try {
            $params = $request->query();
            $record = Create::one($params, $params['course_id'], $params['timing_id']);
            $result = new SuccessResource($record);
        }
        catch(Exception $e) {
            $result = $this->errorFromException($e, 'Ошибка создания записи');
        }

        return $result;
    }

    /**
     * Обновление одной записи
     * POST /api/groups/update?id={}&name={}&studying_start_date={}&studying_end_date={}&examen_date={}&instructor_id={}
     *
     */
    public function updateRecord(Request $request)
    {
        try {
            $params = $request->query();
            $record = Update::one($params, $params['id'], $params['course_id'], $params['timing_id']);
            $result = new SuccessResource($record);
        }
        catch(Exception $e) {
            $result = $this->errorFromException($e, 'Ошибка обновления записи');
        }

        return $result;
    }

    /**
     * Удаление одной записи
     * POST /api/groups/delete?id={}
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

    public function getAvailableTimings(Request $request) {
        try {
            $params = $request->query();
            $record = CalendarValidation::getAvailableTimings($params['filter']['course_id'], $params['filter']['studying_start_date']);
            $result = new SuccessResourceCollection($record);
        }
        catch(Exception $e) {
            $result = $this->errorFromException($e, 'Ошибка получения времени');
        }

        return $result;
    }

    public function getAvailableWeekdays(Request $request) {
        try {
            $params = $request->query();
            $record = CalendarValidation::getAvailableWeekdays($params['filter']['course_id'], $params['filter']['studying_start_date'], $params['filter']['timing_id']);
            $result = new SuccessResourceCollection($record);
        }
        catch(Exception $e) {
            $result = $this->errorFromException($e, 'Ошибка получения дней недели');
        }

        return $result;
    }
}
