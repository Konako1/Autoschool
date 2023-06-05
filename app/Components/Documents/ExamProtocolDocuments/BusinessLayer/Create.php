<?php

namespace App\Components\Documents\ExamProtocolDocuments\BusinessLayer;

use App\Common\DocxTemplateEngine\Templates\ExamProtocolTemplateEngine;
use App\Common\Helpers\DateFormatter;
use App\Components\Documents\ExamProtocolDocuments\Models\ExamProtocolDocument;
use App\Components\Groups\Models\Group;
use App\Components\Modules\Models\Module;
use App\Components\Students\Models\Student;
use Illuminate\Support\Carbon;

class Create
{
    public static function one(string $groupId): ExamProtocolDocument
    {
        $group = Group::find($groupId);
        $students = $group->students();
        $course = $group->course();
        $courseInstructor = $course->instructor();

        $studentsArr = [];
        foreach ($students as $student) {
            $exams = $student->exams();
            $marks = [];
            foreach ($exams as $exam) {
                if ($exam->module()->name == 'Практический экзамен')
                    $marks['practice'] = $exam->mark;
                if ($exam->module()->name == 'Теоретический экзамен')
                    $marks['theory'] = $exam->mark;
            }
            $studentsArr[] = [
                'number' => count($studentsArr) + 1,
                'fio' => "$student->surname $student->name $student->patronymic",
                'theory_mark' => $marks['theory'] ?? null,
                'practice_mark' => $marks['practice'] ?? null,
            ];
        }

        $data = [
            'data' => [
                'date_today' => DateFormatter::format(Carbon::now()),
                'instructor_fio' => "$courseInstructor->surname $courseInstructor->name $courseInstructor->patronymic",
                'group' => [
                    'category' => $course->category()->name,
                    'name' => $group->name,
                ],
                'students' => $studentsArr,
            ]
        ];

        $examProtocolTE = new ExamProtocolTemplateEngine();
        $savedDocumentData = $examProtocolTE->saveDocument($data);
        $savedDocumentData['group_id'] = $group->id;

        $savedDocument = new ExamProtocolDocument($savedDocumentData);
        $savedDocument->save();

        return $savedDocument;
    }
}
