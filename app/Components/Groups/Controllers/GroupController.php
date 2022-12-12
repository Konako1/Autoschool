<?php

namespace App\Components\Groups\Controllers;

use App\Common\Resources\SuccessResource;
use App\Common\Resources\SuccessResourceCollection;
use App\Common\Services\BaseCrudController;
use App\Components\Groups\BusinessLayer\Create;
use App\Components\Groups\BusinessLayer\Delete;
use App\Components\Groups\BusinessLayer\Read;
use App\Components\Groups\BusinessLayer\Update;
use Exception;
use Illuminate\Http\Request;

class GroupController extends BaseCrudController
{
    /**
     * Получение списка записей
     * GET /api/groups/
     *
     */
    public function getAllRecords(Request $request)
    {
        try {
            $params     = $this->getParams($request);
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
     * GET /api/groups/{id}
     *
     */
    public function getRecord(string $id)
    {
        try {
            $records    = Read::byId($id);
            $result     = new SuccessResource($records);
        }
        catch (Exception $e) {
            $result = $e;
        }

        return $result;
    }

    /**
     * Создание одной записи
     * POST /api/groups/
     *
     */
    public function createRecord(Request $request)
    {
        try {
            $data   = $request->get('data');
            $record = Create::one($data);
            $result = new SuccessResource($record);
        }
        catch(Exception $e) {
            $result = $e;
        }

        return $result;
    }

    /**
     * Обновление одной записи
     * PUT /api/groups/{id}
     *
     */
    public function updateRecord(Request $request, string $id)
    {
        try {
            $data   = $request->get('data');
            $record = Update::one($data, $id);
            $result = new SuccessResource($record);
        }
        catch(Exception $e) {
            $result = $e;
        }

        return $result;
    }

    /**
     * Удаление одной записи
     * DELETE /api/groups/{id}
     *
     */
    public function deleteRecord(string $id)
    {
        try {
            $record = Delete::one($id);
            $result = new SuccessResource($record);
        }
        catch(Exception $e) {
            $result = $e;
        }

        return $result;
    }
}
