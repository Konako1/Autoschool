<?php

namespace App\Components\Weekdays\Controllers;

use App\Common\Resources\SuccessResource;
use App\Common\Resources\SuccessResourceCollection;
use App\Common\Services\BaseCrudController;
use App\Components\Weekdays\BusinessLayer\Read;
use Exception;
use Illuminate\Http\Request;

class WeekdayController extends BaseCrudController
{
    public function gerRecords(Request $request)
    {
        try {
            $params     = $this->getParams($request);
            $records    = Read::all($params);
            $total      = Read::count($params);
            $result     = new SuccessResourceCollection($records->toArray(), $total);
        }
        catch (Exception $e) {
            $result = $this->errorFromException($e, 'Ошибка получения записей');
        }

        return $result;
    }

    public function gerRecord(Request $request)
    {
        try {
            $params     = $request->query();
            $records    = Read::byId($params['id']);
            $result     = new SuccessResource($records);
        }
        catch (Exception $e) {
            $result = $this->errorFromException($e, 'Ошибка получения записи');
        }

        return $result;
    }
}
