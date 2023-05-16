<?php

namespace App\Components\Documents\RegistrationOrderDocuments\BusinessLayer;

use App\Common\DocxTemplateEngine\Templates\RegistrationOrderTemplateEngine;
use App\Common\Helpers\DateFormatter;
use App\Components\Documents\RegistrationOrderDocuments\Models\RegistrationOrderDocument;
use App\Components\Groups\Models\Group;
use Carbon\Carbon;

class Create
{
    public static function one(string $groupId): RegistrationOrderDocument
    {
        $group = Group::find($groupId);
        $course = $group->course();
        $modules = $course->modules()->get();
        $students = $group->students();

        $modulesArr = [];
        foreach ($modules as $module) {
            $instructor = $module->instructor();
            $modulesArr[] = [
                'name' => $module->name,
                'instructor' => [
                    'fio' => "$instructor->surname $instructor->name $instructor->patronymic",
                    'education' => $instructor->education,
                    'certificate' => $instructor->certificate,
                    'driver_certificate' => $instructor->driver_certificate,
                    'driver_certificate_category' => $instructor->driver_certificate_category,
                    'job' => $instructor->job,
                ],
            ];
        }

        $instructorsArr = [];
        $studentsArr = [];
        foreach ($students as $key => $student) {
            $instructor = $student->instructor();
            if (!in_array($instructor->id, $instructorsArr)) {
                $instructorsArr[$instructor->id] = [
                    'id' => $instructor->id,
                    'fio' => "$instructor->surname $instructor->name $instructor->patronymic",
                    'education' => $instructor->education,
                    'certificate' => $instructor->certificate,
                    'driver_certificate' => $instructor->driver_certificate,
                    'driver_certificate_category' => $instructor->driver_certificate_category,
                    'job' => $instructor->job,
                ];
            }
            $studentsArr[] = [
                'number' => $key + 1,
                'fio' => "$student->surname $student->name $student->patronymic",
                'birthday' => DateFormatter::stringFormat($student->birthday),
                'address' => $student->address,
            ];
        }

        $data = [
            'data' => [
                'date_today' => DateFormatter::format(Carbon::now()),
                'group' => [
                    'number' => $group->name,
                    'category' => $course->category,
                    'studying_start_date' => DateFormatter::stringFormat($group->studying_start_date),
                    'studying_end_date' => DateFormatter::stringFormat($group->studying_end_date),
                ],
                'modules' => $modulesArr,
                'instructors' => $instructorsArr,
                'students' => $studentsArr,
                'exam' => [
                    'date' => DateFormatter::stringFormat($group->examen_date),
                    'student_count' => count($students),
                ]
            ]
        ];

        $registrationOrderTE = new RegistrationOrderTemplateEngine();
        $savedDocumentData = $registrationOrderTE->saveDocument($data);
        $savedDocumentData['group_id'] = $group->id;

        $savedDocument = new RegistrationOrderDocument($savedDocumentData);
        $savedDocument->save();

        return $savedDocument;
    }
}
