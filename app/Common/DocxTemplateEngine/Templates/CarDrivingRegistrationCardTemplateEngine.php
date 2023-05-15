<?php

namespace App\Common\DocxTemplateEngine\Templates;

use App\Common\DocxTemplateEngine\BaseDocxTemplateEngine;
use App\Common\Exceptions\ValidationException;

class CarDrivingRegistrationCardTemplateEngine extends BaseDocxTemplateEngine
{
    protected static $dataKeys = [
        'data' => [
            'course_category' => null,
            'instructor_fio' => null,
            'group' => [
                'name' => null,
                'studying_start_date' => null,
                'studying_end_date' => null,
            ],
            'student' => [
                'name' => null,
                'surname' => null,
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
            'carDrivingRegistrationCard',
            'carDrivingRegistrationCard.docx'
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
