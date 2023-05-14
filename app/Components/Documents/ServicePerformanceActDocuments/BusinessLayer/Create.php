<?php

namespace App\Components\Documents\ServicePerformanceActDocuments\BusinessLayer;

use App\Common\DocxTemplateEngine\Templates\ServicePerformanceActTemplateEngine;
use App\Components\Documents\ServicePerformanceActDocuments\Models\ServicePerformanceActDocument;
use App\Components\Students\Models\Student;

class Create
{
    public static function one(string $studentId): ServicePerformanceActDocument
    {
        $student = Student::find($studentId);
        $data = [
            'data' => [
                'student' => [
                    'fio' => "{$student->surname} {$student->name} {$student->patronymic}",
                    'address' => $student->address,
                ]
            ]
        ];

        $servicePerformanceActTE = new ServicePerformanceActTemplateEngine();
        $savedDocumentData = $servicePerformanceActTE->saveDocument($data);
        $savedDocumentData['student_id'] = $student->id;

        $savedDocument = new ServicePerformanceActDocument($savedDocumentData);
        $savedDocument->save();

        return $savedDocument;
    }

}
