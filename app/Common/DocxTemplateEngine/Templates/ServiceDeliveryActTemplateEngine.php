<?php

namespace App\Common\DocxTemplateEngine\Templates;

use App\Common\DocxTemplateEngine\BaseDocxTemplateEngine;
use App\Common\Exceptions\ValidationException;

class ServiceDeliveryActTemplateEngine extends BaseDocxTemplateEngine
{
    protected static $dataKeys = [
        'data' => [
            'from_date' => null,
            'courses_sum' => null,
            'courses' => [
                '*' => [
                    'name' => null,
                    'price' => null,
                    'count' => null,
                    'sum' => null,
                ],
            ],
            'student' => [
                'fio' => null,
            ],
        ]
    ];

    public function __construct()
    {
        parent::__construct(
            'serviceDeliveryAct',
            'serviceDeliveryAct.docx'
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
