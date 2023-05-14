<?php

namespace App\Common\DocxTemplateEngine\Templates;

use App\Common\DocxTemplateEngine\BaseDocxTemplateEngine;
use App\Common\Exceptions\ValidationException;

class DriverExamCardTemplateEngine extends BaseDocxTemplateEngine
{
    protected static $dataKeys = [
        'data' => [
            'course_name' => null,
            'group_name' => null,
            'year' => null,
            'student' => [
                'surname' => null,
                'name' => null,
                'patronymic' => null,
                'birthday' => null,
                'address' => null,
            ],
        ]
    ];

    public function __construct()
    {
        parent::__construct(
            'driverExamCard',
            'driverExamCard.docx'
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
