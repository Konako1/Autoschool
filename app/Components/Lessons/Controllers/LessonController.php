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
            if (isset($params['filter']['module']) && isset($params['filter']['group']))
                $result = $this->getAllRecordsByModuleAndGroup($params);
            elseif (isset($params['filter']['module']))
                $result = $this->getAllRecordsByModule($params);
            elseif (isset($params['filter']['group']))
                $result = $this->getAllRecordsByGroup($params);
            else
                $result = $this->getAllRecords($params);
        }
        catch (Exception $e) {
            $result = $e;
        }

        return $result;
    }

    /**
     * Получение списка записей
     * GET /api/lessons/
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
            $result = $e;
        }

        return $result;
    }

    /**
     * Получение списка записей по модулю
     * GET /api/lessons?filter[module]={[0-9]+}
     *
     */
    public function getAllRecordsByModule(array $params)
    {
        try {
            $records    = Read::allByModuleId($params['filter']['module'], $params);
            $total      = Read::count($params, null, $params['filter']['module']);
            $result     = new SuccessResourceCollection($records->toArray(), $total);
        }
        catch (Exception $e) {
            $result = $e;
        }

        return $result;
    }

    /**
     * Получение списка записей по группе
     * GET /api/lessons?filter[group]={[0-9]+}
     *
     */
    public function getAllRecordsByGroup(array $params)
    {
        try {
            $records    = Read::allByGroupId($params['filter']['group'], $params);
            $total      = Read::count($params, $params['filter']['group']);
            $result     = new SuccessResourceCollection($records->toArray(), $total);
        }
        catch (Exception $e) {
            $result = $e;
        }

        return $result;
    }

    /**
     * Получение списка записей по группе и модулю
     * GET /api/lessons?filter[group]={[0-9]+}
     *
     */
    public function getAllRecordsByModuleAndGroup(array $params)
    {
        try {
            $records    = Read::allByGroupAndModuleId(
                $params['filter']['group'],
                $params['filter']['module'],
                $params
            );
            $total      = Read::count(
                $params,
                $params['filter']['group'],
                $params['filter']['module']
            );
            $result     = new SuccessResourceCollection($records->toArray(), $total);
        }
        catch (Exception $e) {
            $result = $e;
        }

        return $result;
    }

    /**
     * Получение записи
     * GET /api/lessons/one?id={id}&module={}&group={}
     *
     */
    public function getRecord(Request $request)
    {
        try {
            $params = $request->query();
            $records    = Read::byId($params['module'], $params['group'], $params['id']);
            $result     = new SuccessResource($records);
        }
        catch (Exception $e) {
            $result = $e;
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
            $result = $e;
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
            $result = $e;
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
            $result = $e;
        }

        return $result;
    }
}
