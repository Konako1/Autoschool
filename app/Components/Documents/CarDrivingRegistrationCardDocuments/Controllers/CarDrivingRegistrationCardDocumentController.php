<?php

namespace App\Components\Documents\CarDrivingRegistrationCardDocuments\Controllers;

use App\Common\Services\BaseCrudController;
use App\Components\Documents\CarDrivingRegistrationCardDocuments\BusinessLayer\Create;
use Exception;
use Illuminate\Http\Request;

class CarDrivingRegistrationCardDocumentController extends BaseCrudController
{
    /**
     * Создание одной записи
     * POST /api/documents/car-driving-registration-card/create?...
     *
     */
    public function createRecord(Request $request)
    {
        try {
            $params = $request->query();
            $document = Create::one($params['student_id']);
        }
        catch(Exception $e) {
            return $this->errorFromException($e, 'Ошибка формирования документа');
        }

        return $this->downloadFile($document);
    }
}
