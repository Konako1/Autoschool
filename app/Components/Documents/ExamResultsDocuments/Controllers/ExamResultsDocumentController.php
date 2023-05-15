<?php

namespace App\Components\Documents\ExamResultsDocuments\Controllers;

use App\Common\Services\BaseCrudController;
use App\Components\Documents\ExamResultsDocuments\BusinessLayer\Create;
use Exception;
use Illuminate\Http\Request;

class ExamResultsDocumentController extends BaseCrudController
{
    /**
     * Создание одной записи
     * POST /api/documents/exam-results/create?...
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
