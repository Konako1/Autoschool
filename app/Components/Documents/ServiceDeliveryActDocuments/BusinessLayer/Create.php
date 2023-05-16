<?php

namespace App\Components\Documents\ServiceDeliveryActDocuments\BusinessLayer;

use App\Common\DocxTemplateEngine\Templates\ServiceDeliveryActTemplateEngine;
use App\Common\Helpers\DateFormatter;
use App\Components\Documents\ServiceDeliveryActDocuments\Models\ServiceDeliveryActDocument;
use App\Components\Students\Models\Student;

class Create
{
    public static function one(string $studentId): ServiceDeliveryActDocument
    {
        $student = Student::find($studentId);
        $group = $student->group();
        $course = $group->course();
        $coursePrice = 0.0;

        if (isset($course)) {
            $coursePrice = sprintf("%.2f", $course->price);
        }

        $coursesArr[] = [
            'name' => $course->name,
            'price' => $coursePrice,
            'count' => count([$course]),
            'sum' => $coursePrice,
        ];

        $data = [
            'data' => [
                'from_date' => DateFormatter::stringFormat($group->studying_end_date),
                'courses_sum' => $coursePrice,
                'courses' => $coursesArr,
                'student' => [
                    'fio' => "$student->surname $student->name $student->patronymic",
                ],
            ]
        ];

        $serviceDeliveryActTE = new ServiceDeliveryActTemplateEngine();
        $savedDocumentData = $serviceDeliveryActTE->saveDocument($data);
        $savedDocumentData['student_id'] = $student->id;

        $savedDocument = new ServiceDeliveryActDocument($savedDocumentData);
        $savedDocument->save();

        return $savedDocument;
    }
}
