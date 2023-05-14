<?php

namespace App\Components\Documents\ServiceDeliveryActDocuments\Controllers;

use App\Common\Services\BaseCrudController;
use App\Components\Documents\ServiceDeliveryActDocuments\BusinessLayer\Create;
use Exception;
use Illuminate\Http\Request;

class ServiceDeliveryActDocumentController extends BaseCrudController
{
    /**
     * Создание одной записи
     * POST /api/documents/service-performance-act/create?...
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
