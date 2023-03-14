<?php

namespace App\Components\Exams\Controllers;

use App\Common\Resources\SuccessResource;
use App\Common\Resources\SuccessResourceCollection;
use App\Common\Services\BaseCrudController;
use App\Components\Exams\BusinessLayer\Create;
use App\Components\Exams\BusinessLayer\Delete;
use App\Components\Exams\BusinessLayer\Read;
use App\Components\Exams\BusinessLayer\Update;
use Exception;
use Illuminate\Http\Request;

class ExamController extends BaseCrudController
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
            if (isset($params['filter']['student']))
                $result = $this->getAllRecordsByStudent($params);
            else
                $result = $this->getAllRecords($params);
        }
        catch (Exception $e) {
            $result = $this->errorFromException($e, 'Ошибка получения записей');
        }

        return $result;
    }

    /**
     * Получение списка записей
     * GET /api/exams/
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
     * GET /api/exams?filter[student]={[0-9]+}
     *
     */
    public function getAllRecordsByStudent(array $params)
    {
        try {
            $records    = Read::allByStudentId($params['filter']['student'], $params);
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
     * GET /api/exams/one?id={id}&student={id}
     *
     */
    public function getRecord(Request $request)
    {
        try {
            $params = $request->query();
            $records    = Read::byId($params['student'], $params['id']);
            $result     = new SuccessResource($records);
        }
        catch (Exception $e) {
            $result = $this->errorFromException($e, 'Ошибка получения записи');
        }

        return $result;
    }

    /**
     * Создание одной записи
     * POST /api/exams/create?name={}&mark={}&student_id={}&date={}
     *
     */
    public function createRecord(Request $request)
    {
        try {
            $params = $request->query();
            $record = Create::one($params, $params['student_id']);
            $result = new SuccessResource($record);
        }
        catch(Exception $e) {
            $result = $this->errorFromException($e, 'Ошибка создания записи');
        }

        return $result;
    }

    /**
     * Обновление одной записи
     * POST /api/exams/update?id={}&name={}&mark={}&student_id={}&date={}
     *
     */
    public function updateRecord(Request $request)
    {
        try {
            $params = $request->query();
            $record = Update::one($params, $params['id'], $params['student_id']);
            $result = new SuccessResource($record);
        }
        catch(Exception $e) {
            $result = $this->errorFromException($e, 'Ошибка обновления записи');
        }

        return $result;
    }

    /**
     * Удаление одной записи
     * POST /api/exams/delete?id={}
     *
     */
    public function deleteRecord(Request $request)
    {
        try {
            $params = $request->query();
            $record = Delete::one($params['id'], $params['student_id']);
            $result = new SuccessResource($record);
        }
        catch(Exception $e) {
            $result = $this->errorFromException($e, 'Ошибка удаления записи');
        }

        return $result;
    }
}
