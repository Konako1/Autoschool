<?php

namespace App\Common\DocxTemplateEngine\Templates;

use App\Common\DocxTemplateEngine\BaseDocxTemplateEngine;
use App\Common\Exceptions\ValidationException;

class RegistrationOrderTemplateEngine extends BaseDocxTemplateEngine
{
    protected static $dataKeys = [
        'data' => [
            'date_today' => null,
            'group' => [
                'name' => null,
                'category' => null,
                'studying_start_date' => null,
                'studying_end_date' => null,
            ],
            'course' => [
                'name' => null,
                'instructor' => [
                    'fio' => null,
                    'education' => null,
                    'certificate' => null,
                    'driver_certificate' => null,
                    'category' => null,
                    'job' => null,
                ],
            ],
            'instructors' => [
                '*' => [
                    'id' => null,
                    'fio' => null,
                    'education' => null,
                    'certificate' => null,
                    'driver_certificate' => null,
                    'category' => null,
                    'job' => null,
                ]
            ],
            'students' => [
                '*' => [
                    'number' => null,
                    'fio' => null,
                    'birthday' => null,
                    'address' => null,
                ]
            ],
        ]
    ];

    public function __construct()
    {
        parent::__construct(
            'registrationOrder',
            'registrationOrder.docx'
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
