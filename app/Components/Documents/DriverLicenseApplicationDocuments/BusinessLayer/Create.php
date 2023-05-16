<?php

namespace App\Components\Documents\DriverLicenseApplicationDocuments\BusinessLayer;

use App\Common\DocxTemplateEngine\Templates\DriverLicenseApplicationTemplateEngine;
use App\Common\Helpers\DateFormatter;
use App\Components\Documents\DriverLicenseApplicationDocuments\Models\DriverLicenseApplicationDocument;
use App\Components\Students\Models\Student;
use Carbon\Carbon;

class Create
{
    public static function one(string $studentId): DriverLicenseApplicationDocument
    {
        $student = Student::find($studentId);
        $group = $student->group();
        $course = $group->course();

        $data = [
            'data' => [
                'date_today' => DateFormatter::format(Carbon::now()),
                'group' => [
                    'category' => $course->category,
                    'name' => $group->name,
                ],
                'student' => [
                    'fio' => "$student->surname $student->name $student->patronymic",
                    'birthday' => DateFormatter::stringFormat($student->birthday),
                    'address' => $student->address,
                    'phone' => $student->phone,
                ],
            ]
        ];

        $driverExamCardTE = new DriverLicenseApplicationTemplateEngine();
        $savedDocumentData = $driverExamCardTE->saveDocument($data);
        $savedDocumentData['student_id'] = $student->id;

        $savedDocument = new DriverLicenseApplicationDocument($savedDocumentData);
        $savedDocument->save();

        return $savedDocument;
    }
}
