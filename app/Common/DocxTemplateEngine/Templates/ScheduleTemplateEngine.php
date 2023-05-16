<?php

namespace App\Common\DocxTemplateEngine\Templates;

use App\Common\DocxTemplateEngine\BaseDocxTemplateEngine;
use App\Common\Exceptions\ValidationException;

class ScheduleTemplateEngine extends BaseDocxTemplateEngine
{
    protected static $dataKeys = [
        'data' => [
            'date_today' => null,
            'group' => [
                'category' => null,
                'name' => null,
                'time_start' => null,
                'time_end' => null,
            ],
            'lessons' => [
                '*' => [
                    'date' => null,
                    'time' => null,
                    'module_name' => null,
                    'instructor_fio' => null,
                ]
            ],
        ]
    ];

    public function __construct()
    {
        parent::__construct(
            'schedule',
            'schedule.docx'
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
