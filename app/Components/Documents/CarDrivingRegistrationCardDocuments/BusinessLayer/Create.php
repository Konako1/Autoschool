<?php

namespace App\Components\Documents\CarDrivingRegistrationCardDocuments\BusinessLayer;

use App\Common\DocxTemplateEngine\Templates\CarDrivingRegistrationCardTemplateEngine;
use App\Common\Helpers\DateFormatter;
use App\Components\Documents\CarDrivingRegistrationCardDocuments\Models\CarDrivingRegistrationCardDocument;
use App\Components\Students\Models\Student;

class Create
{
    public static function one(string $studentId): CarDrivingRegistrationCardDocument
    {
        $student = Student::find($studentId);
        $group = $student->group();
        $course = $group->course();
        $instructor = $student->instructor();
        $car = $instructor->car();

        $name_char = str_split("$instructor->name", 2)[0];
        $patronymic_char = str_split("$instructor->patronymic", 2)[0];
        $data = [
            'data' => [
                'course_category' => $course->category()->name,
                'instructor_fio' => "$instructor->surname $name_char. $patronymic_char.",
                'group' => [
                    'name' => $group->name,
                    'studying_start_date' => DateFormatter::stringFormat($group->studying_start_date),
                    'studying_end_date' => DateFormatter::stringFormat($group->studying_end_date),
                ],
                'student' => [
                    'name' => $student->name,
                    'surname' => $student->surname,
                    'patronymic' => $student->patronymic,
                ],
                'car' => [
                    'name' => $car->name,
                    'reg_number' => $car->reg_number,
                ]
            ]
        ];

        $carDrivingRegistrationCardTE = new CarDrivingRegistrationCardTemplateEngine();
        $savedDocumentData = $carDrivingRegistrationCardTE->saveDocument($data);
        $savedDocumentData['student_id'] = $student->id;

        $savedDocument = new CarDrivingRegistrationCardDocument($savedDocumentData);
        $savedDocument->save();

        return $savedDocument;
    }
}
