<?php

namespace App\Components\Documents\DriverExamCardDocuments\BusinessLayer;

use App\Common\DocxTemplateEngine\Templates\DriverExamCardTemplateEngine;
use App\Common\Helpers\DateFormatter;
use App\Components\Documents\DriverExamCardDocuments\Models\DriverExamCardDocument;
use App\Components\Students\Models\Student;
use Carbon\Carbon;

class Create
{
    public static function one(string $studentId): DriverExamCardDocument
    {
        $student = Student::find($studentId);
        $group = $student->group();
        $course = $group->course();

        $data = [
            'data' => [
                'course_name' => $course->name,
                'group_name' => $group->name,
                'year' => Carbon::now()->year,
                'student' => [
                    'surname' => $student->surname,
                    'name' => $student->name,
                    'patronymic' => $student->patronymic,
                    'birthday' => DateFormatter::stringFormat($student->birthday),
                    'address' => $student->address,
                ],
            ]
        ];

        $driverExamCardTE = new DriverExamCardTemplateEngine();
        $savedDocumentData = $driverExamCardTE->saveDocument($data);
        $savedDocumentData['student_id'] = $student->id;

        $savedDocument = new DriverExamCardDocument($savedDocumentData);
        $savedDocument->save();

        return $savedDocument;
    }
}
