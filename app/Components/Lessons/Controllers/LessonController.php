<?php

namespace App\Components\Lessons\Controllers;

use App\Common\Resources\SuccessResource;
use App\Common\Resources\SuccessResourceCollection;
use App\Common\Services\BaseCrudController;
use App\Components\Lessons\BusinessLayer\Create;
use App\Components\Lessons\BusinessLayer\Delete;
use App\Components\Lessons\BusinessLayer\Read;
use App\Components\Lessons\BusinessLayer\Update;
use Exception;
use Illuminate\Http\Request;

class LessonController extends BaseCrudController
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
     * GET /api/lessons/
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
     * Создание одной записи
     * POST /api/lessons/create?time_start={}&time_end={}&module_id={}&group_id={}
     *
     */
    public function createRecord(Request $request)
    {
        try {
            $params = $request->query();
            $record = Create::one($params, $params['module_id'], $params['group_id']);
            $result = new SuccessResource($record);
        }
        catch(Exception $e) {
            $result = $this->errorFromException($e, 'Ошибка создания записи');
        }

        return $result;
    }

    /**
     * Обновление одной записи
     * POST /api/lessons/update?id={}&time_start={}&time_end={}&module_id={}&group_id={}
     *
     */
    public function updateRecord(Request $request)
    {
        try {
            $params = $request->query();
            $record = Update::one($params, $params['id'],$params['module_id'], $params['group_id']);
            $result = new SuccessResource($record);
        }
        catch(Exception $e) {
            $result = $this->errorFromException($e, 'Ошибка обновления записи');
        }

        return $result;
    }

    /**
     * Удаление одной записи
     * POST /api/lessons/delete?id={}&module_id={}&group_id={}
     *
     */
    public function deleteRecord(Request $request)
    {
        try {
            $params = $request->query();
            $record = Delete::one($params['id'], $params['module_id'], $params['group_id']);
            $result = new SuccessResource($record);
        }
        catch(Exception $e) {
            $result = $this->errorFromException($e, 'Ошибка удаления записи');
        }

        return $result;
    }
}
