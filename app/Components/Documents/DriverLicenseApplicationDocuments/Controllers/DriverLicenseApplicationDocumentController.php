<?php

namespace App\Components\Documents\DriverLicenseApplicationDocuments\Controllers;

use App\Common\Services\BaseCrudController;
use App\Components\Documents\DriverLicenseApplicationDocuments\BusinessLayer\Create;
use Exception;
use Illuminate\Http\Request;

class DriverLicenseApplicationDocumentController extends BaseCrudController
{
    /**
     * Создание одной записи
     * POST /api/documents/driver-license-application/create?...
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
