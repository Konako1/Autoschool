<?php

namespace App\Common\DocxTemplateEngine\Templates;

use App\Common\DocxTemplateEngine\BaseDocxTemplateEngine;
use App\Common\Exceptions\ValidationException;

class GroupDebtTemplateEngine extends BaseDocxTemplateEngine
{
    protected static $dataKeys = [
        'data' => [
            'date_today' => null,
            'students' => [
                '*' => [
                    'number' => null,
                    'group_name' => null,
                    'fio' => null,
                    'debt' => null,
                ]
            ],
            'debt' => null,
        ]
    ];

    public function __construct()
    {
        parent::__construct(
            'groupDebt',
            'groupDebt.docx'
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
