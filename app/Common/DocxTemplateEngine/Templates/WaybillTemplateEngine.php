<?php

namespace App\Common\DocxTemplateEngine\Templates;

use App\Common\DocxTemplateEngine\BaseDocxTemplateEngine;
use App\Common\Exceptions\ValidationException;
use App\Components\Documents\TestDocuments\Models\TestDocument;

class WaybillTemplateEngine extends BaseDocxTemplateEngine
{
    protected static $dataKeys = [
        'data' => [
            'group_number' => null,
            'instructor_fio' => null,
            'student' => [
                'surname' => null,
                'name' => null,
                'patronymic' => null,
            ],
            'car' => [
                'name' => null,
                'reg_number' => null,
            ]
        ]
    ];

    public function __construct()
    {
        parent::__construct(
            'waybill',
            'waybill.docx'
        );
    }

    /**
     * @return array Saved Document data
     *@throws ValidationException
     *
     */
    public function saveDocument(array $data): array
    {
        return parent::saveDocument($data);
    }
}
