<?php

namespace App\Components\Documents\GroupDebtDocuments\Controllers;

use App\Common\Services\BaseCrudController;
use App\Components\Documents\GroupDebtDocuments\BusinessLayer\Create;
use Exception;
use Illuminate\Http\Request;

class GroupDebtDocumentController extends BaseCrudController
{
    /**
     * Создание одной записи
     * POST /api/documents/group-debt/create?...
     *
     */
    public function createRecord(Request $request)
    {
        try {
            $params = $request->query();
            $document = Create::one($params['group_id'] ?? null);
        }
        catch(Exception $e) {
            return $this->errorFromException($e, 'Ошибка формирования документа');
        }

        return $this->downloadFile($document);
    }
}
