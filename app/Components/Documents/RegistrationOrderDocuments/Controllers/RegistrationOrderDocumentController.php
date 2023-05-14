<?php

namespace App\Components\Documents\RegistrationOrderDocuments\Controllers;

use App\Common\Services\BaseCrudController;
use App\Components\Documents\RegistrationOrderDocuments\BusinessLayer\Create;
use Exception;
use Illuminate\Http\Request;

class RegistrationOrderDocumentController extends BaseCrudController
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
            $document = Create::one($params['group_id']);
        }
        catch(Exception $e) {
            return $this->errorFromException($e, 'Ошибка формирования документа');
        }

        return $this->downloadFile($document);
    }
}
