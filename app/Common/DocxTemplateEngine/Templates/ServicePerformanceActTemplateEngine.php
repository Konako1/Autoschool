<?php

namespace App\Common\DocxTemplateEngine\Templates;

use App\Common\DocxTemplateEngine\BaseDocxTemplateEngine;
use App\Common\Exceptions\ValidationException;

class ServicePerformanceActTemplateEngine extends BaseDocxTemplateEngine
{
    protected static $dataKeys = [
        'data' => [
            'student' => [
                'fio' => null,
                'address' => null,
            ],
            'course_hours' => null,
            'category' => null,
        ]
    ];

    public function __construct()
    {
        parent::__construct(
            'servicePerformanceAct',
            'servicePerformanceAct.docx'
        );
    }

    /**
     * @return array Saved document data
     *@throws ValidationException
     *
     */
    public function saveDocument(array $data): array
    {
        return parent::saveDocument($data);
    }
}
