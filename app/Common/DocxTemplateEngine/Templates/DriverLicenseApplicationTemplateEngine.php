<?php

namespace App\Common\DocxTemplateEngine\Templates;

use App\Common\DocxTemplateEngine\BaseDocxTemplateEngine;
use App\Common\Exceptions\ValidationException;

class DriverLicenseApplicationTemplateEngine extends BaseDocxTemplateEngine
{
    protected static $dataKeys = [
        'data' => [
            'date_today' => null,
            'group' => [
                'category' => null,
                'name' => null,
            ],
            'student' => [
                'fio' => null,
                'birthday' => null,
                'address' => null,
                'phone' => null,
            ],
        ]
    ];

    public function __construct()
    {
        parent::__construct(
            'driverLicenseApplication',
            'driverLicenseApplication.docx'
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
