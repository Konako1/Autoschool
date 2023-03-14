<?php

namespace App\Components\Students\Controllers;

use App\Common\Resources\SuccessResource;
use App\Common\Resources\SuccessResourceCollection;
use App\Common\Services\BaseCrudController;
use App\Components\Students\BusinessLayer\Create;
use App\Components\Students\BusinessLayer\Delete;
use App\Components\Students\BusinessLayer\Read;
use App\Components\Students\BusinessLayer\Update;
use Exception;
use Illuminate\Http\Request;

class StudentController extends BaseCrudController
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
            if (isset($params['filter']['group']))
                $result = $this->getAllRecordsByGroup($params);
            else
                $result = $this->getAllRecords($params);
        }
        catch (Exception $e) {
            $result = $this->errorFromException($e, 'Ошибка получения записей');
        }

        return $result;
    }

    /**
     * Получение списка записей вне зависимости от группы
     * GET api/students
     *
     */
    public function getAllRecords(array $params)
    {
        try {
            $records    = Read::all($params);
            $total      = Read::count($params);
            $result     = new SuccessResourceCollection($records->toArray(), $total);
        }
        catch (Exception $e) {
            $result = $this->errorFromException($e, 'Ошибка получения записей');
        }

        return $result;
    }

    /**
     * Получение списка записей по группе
     * GET /api/students?filter[group]={[0-9]+}
     *
     */
    public function getAllRecordsByGroup(array $params)
    {
        try {
            $records    = Read::allByGroupId($params['filter']['group'], $params);
            $total      = Read::count($params);
            $result     = new SuccessResourceCollection($records->toArray(), $total);
        }
        catch (Exception $e) {
            $result = $this->errorFromException($e, 'Ошибка получения записей');
        }

        return $result;
    }

    /**
     * Получение записи
     * GET /api/students/one?group={}&id={id}
     *
     */
    public function getRecord(Request $request)
    {
        try {
            $params = $request->query();
            $records    = Read::byId($params['group'], $params['id']);
            $result     = new SuccessResource($records);
        }
        catch (Exception $e) {
            $result = $this->errorFromException($e, 'Ошибка получения записи');
        }

        return $result;
    }

    /**
     * Создание одной записи
     * POST /api/students/create?params...
     *
     */
    public function createRecord(Request $request)
    {
        try {
            $params = $request->query();
            $record = Create::one($params, $params['group_id']);
            $result = new SuccessResource($record);
        }
        catch(Exception $e) {
            $result = $this->errorFromException($e, 'Ошибка создания записи');
        }

        return $result;
    }

    /**
     * Обновление одной записи
     * POST /api/students/update?params...
     *
     */
    public function updateRecord(Request $request)
    {
        try {
            $params = $request->query();
            $record = Update::one($params, $params['group_id'], $params['id']);
            $result = new SuccessResource($record);
        }
        catch(Exception $e) {
            $result = $this->errorFromException($e, 'Ошибка обновления записи');
        }

        return $result;
    }

    /**
     * Удаление одной записи
     * POST /api/students/delete?group_id={}&id={}
     *
     */
    public function deleteRecord(Request $request)
    {
        try {
            $params = $request->query();
            $record = Delete::one($params['group_id'], $params['id']);
            $result = new SuccessResource($record);
        }
        catch(Exception $e) {
            $result = $this->errorFromException($e, 'Ошибка удаления записи');
        }

        return $result;
    }
}
