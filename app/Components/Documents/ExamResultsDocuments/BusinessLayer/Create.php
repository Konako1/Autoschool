<?php

namespace App\Components\Documents\ExamResultsDocuments\BusinessLayer;

use App\Common\DocxTemplateEngine\Templates\ExamResultsTemplateEngine;
use App\Common\Helpers\DateFormatter;
use App\Components\Documents\ExamResultsDocuments\Models\ExamResultsDocument;
use App\Components\Groups\Models\Group;
use Carbon\Carbon;

class Create
{
    public static function one(string $groupId): ExamResultsDocument
    {
        $group = Group::find($groupId);
        $course = $group->course();

        $data = [
            'data' => [
                'date_today' => DateFormatter::format(Carbon::now()),
                'group' => [
                    'name' => $group->name,
                    'course_category' => $course->category,
                    'students_count' => count($group->students()),
                ],
            ]
        ];

        $examResultsTE = new ExamResultsTemplateEngine();
        $savedDocumentData = $examResultsTE->saveDocument($data);
        $savedDocumentData['group_id'] = $group->id;

        $savedDocument = new ExamResultsDocument($savedDocumentData);
        $savedDocument->save();

        return $savedDocument;
    }
}
