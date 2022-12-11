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
     * Получение списка записей вне зависимости от группы
     * GET api/students
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
            $result = new Exception('Ошибка при получении');
        }

        return $result;
    }

    /**
     * Получение списка записей
     * GET /api/groups/{groupId:[0-9]+}/students
     *
     */
    public function getAllRecordsByGroup(Request $request, string $groupId)
    {
        try {
            $params     = $this->getParams($request);
            $records    = Read::allByGroupId($groupId, $params);
            $total      = Read::count($params);
            $result     = new SuccessResourceCollection($records->toArray(), $total);
        }
        catch (Exception $e) {
            $result = new Exception('Ошибка при получении');
        }

        return $result;
    }

    /**
     * Получение записи
     * GET /api/groups/{groupId:[0-9]+}/students/{id}
     *
     */
    public function getRecord(string $groupId, string $id)
    {
        try {
            $records    = Read::byId($groupId, $id);
            $result     = new SuccessResource($records);
        }
        catch (Exception $e) {
            $result = new Exception('Ошибка при получении');
        }

        return $result;
    }

    /**
     * Создание одной записи
     * POST /api/groups/{groupId:[0-9]+}/students
     *
     */
    public function createRecord(Request $request, string $groupId)
    {
        try {
            $data = $this->getData($request);
            $record = Create::one($data, $groupId);
            $result = new SuccessResource($record);
        }
        catch(Exception $e) {
            $result = new Exception('Ошибка при создании');
        }

        return $result;
    }

    /**
     * Обновление одной записи
     * PUT /api/groups/{groupId:[0-9]+}/students/{id}
     *
     */
    public function updateRecord(Request $request, string $groupId, string $id)
    {
        try {
            $data = $this->getData($request);
            $record = Update::one($data, $groupId, $id);
            $result = new SuccessResource($record);
        }
        catch(Exception $e) {
            $result = new Exception('Ошибка при обновлении');
        }

        return $result;
    }

    /**
     * Удаление одной записи
     * DELETE /api/groups/{groupId:[0-9]+}/students/{id}
     *
     */
    public function deleteRecord(string $groupId, string $id)
    {
        try {
            $record = Delete::one($groupId, $id);
            $result = new SuccessResource($record);
        }
        catch(Exception $e) {
            $result = new Exception('Ошибка при удалении');
        }

        return $result;
    }
}
