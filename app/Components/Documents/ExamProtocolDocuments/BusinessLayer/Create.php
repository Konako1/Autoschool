<?php

namespace App\Components\Documents\ExamProtocolDocuments\BusinessLayer;

use App\Common\DocxTemplateEngine\Templates\ExamProtocolTemplateEngine;
use App\Common\Helpers\DateFormatter;
use App\Components\Documents\ExamProtocolDocuments\Models\ExamProtocolDocument;
use App\Components\Students\Models\Student;
use Illuminate\Support\Carbon;

class Create
{
    public static function one(string $studentId): ExamProtocolDocument
    {
        $student = Student::find($studentId);
        $group = $student->group();
        $studentInstructor = $student->instructor();
        $course = $group->course();
        $exams = $student->exams();

        $examArr = [];
        foreach ($exams as $exam) {
            // TODO: заменить инструктора по вождению на инструктора из модуля (и подвязать экзамены к модулю)
            $examArr[] = [
                'name' => $exam->name,
                'mark' => $exam->mark,
                'instructor_fio' => "$studentInstructor->surname $studentInstructor->name $studentInstructor->patronymic",
            ];
        }

        $data = [
            'data' => [
                'date_today' => DateFormatter::format(Carbon::now()),
                'instructor_fio' => "$studentInstructor->surname $studentInstructor->name $studentInstructor->patronymic",
                'group' => [
                    'category' => $course->category,
                    'name' => $group->name,
                ],
                'student' => [
                    'fio' => "$student->surname $student->name $student->patronymic",
                ],
                'exams' => $examArr,
            ]
        ];

        $driverExamCardTE = new ExamProtocolTemplateEngine();
        $savedDocumentData = $driverExamCardTE->saveDocument($data);
        $savedDocumentData['student_id'] = $student->id;

        $savedDocument = new ExamProtocolDocument($savedDocumentData);
        $savedDocument->save();

        return $savedDocument;
    }
}
