<?php

namespace App\Components\Cars\Controllers;

use App\Common\Resources\SuccessResource;
use App\Common\Resources\SuccessResourceCollection;
use App\Common\Services\BaseCrudController;
use App\Components\Cars\BusinessLayer\Create;
use App\Components\Cars\BusinessLayer\Delete;
use App\Components\Cars\BusinessLayer\Read;
use App\Components\Cars\BusinessLayer\Update;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class CarController extends BaseCrudController
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
            $result = $this->getAllRecords($params);
        }
        catch (Exception $e) {
            $result = $e;
        }

        return $result;
    }

    /**
     * Получение списка записей
     * GET /api/cars/
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
     * Получение записи
     * GET /api/cars/one?id={id}
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
            $result = $e;
        }

        return $result;
    }

    /**
     * Создание одной записи
     * POST /api/cars/create?name={}&reg_number={}
     *
     */
    public function createRecord(Request $request)
    {
        try {
            $params = $request->query();
            $record = Create::one($params);
            $result = new SuccessResource($record);
        }
        catch(Exception $e) {
            $result = $e;
        }

        return $result;
    }

    /**
     * Обновление одной записи
     * POST /api/cars/create?id={}name={}&reg_number={}
     *
     */
    public function updateRecord(Request $request)
    {
        try {
            $params = $request->query();
            $record = Update::one($params, $params['id']);
            $result = new SuccessResource($record);
        }
        catch(Exception $e) {
            $result = $e;
        }

        return $result;
    }

    /**
     * Удаление одной записи
     * POST /api/cars/delete?id={}
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
            $result = $e;
        }

        return $result;
    }
}