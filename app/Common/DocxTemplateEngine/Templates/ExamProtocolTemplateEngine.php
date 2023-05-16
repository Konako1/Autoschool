<?php

namespace App\Common\DocxTemplateEngine\Templates;

use App\Common\DocxTemplateEngine\BaseDocxTemplateEngine;
use App\Common\Exceptions\ValidationException;

class ExamProtocolTemplateEngine extends BaseDocxTemplateEngine
{
    protected static $dataKeys = [
        'data' => [
            'date_today' => null,
            'instructor_fio' => null,
            'group' => [
                'category' => null,
                'name' => null,
            ],
            'student' => [
                'fio' => null,
            ],
            'exams' => [
                '*' => [
                    'name' => null,
                    'mark' => null,
                    'instructor_fio' => null,
                ]
            ]
        ]
    ];

    public function __construct()
    {
        parent::__construct(
            'examProtocol',
            'examProtocol.docx'
        );
    }

    /**
     * @return array Saved document data
     * @throws ValidationException
     *
     */
    public function saveDocument(array $data): array
    {
        return parent::saveDocument($data);
    }
}
