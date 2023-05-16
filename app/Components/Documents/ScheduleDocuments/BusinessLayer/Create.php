<?php

namespace App\Components\Documents\ScheduleDocuments\BusinessLayer;

use App\Common\DocxTemplateEngine\Templates\ScheduleTemplateEngine;
use App\Common\Helpers\DateFormatter;
use App\Components\Documents\ScheduleDocuments\Models\ScheduleDocument;
use App\Components\Groups\Models\Group;
use Carbon\Carbon;

class Create
{
    public static function one(string $groupId): ScheduleDocument
    {
        $group = Group::find($groupId);
        $course = $group->course();
        $lessons = $group->lessons();

        $lessonsArr = [];
        foreach ($lessons as $lesson) {
            $timeStart = Carbon::createFromFormat('Y-m-d H:i:s', $lesson->time_start)->toTimeString();
            $timeEnd = Carbon::createFromFormat('Y-m-d H:i:s', $lesson->time_end)->toTimeString();
            $module = $lesson->module();
            $instructor = $module->instructor();
            $name_char = str_split("$instructor->name", 2)[0];
            $patronymic_char = str_split("$instructor->patronymic", 2)[0];


            $lessonsArr[] = [
                'date' => DateFormatter::stringFormatWithTime($lesson->time_start),
                'time' => "$timeStart — $timeEnd",
                'module_name' => $module->name,
                'instructor_fio' => "$instructor->surname $name_char. $patronymic_char.",
            ];
        }

        $data = [
            'data' => [
                'date_today' => DateFormatter::format(Carbon::now()),
                'group' => [
                    'category' => $course->category,
                    'name' => $group->name,
                    'time_start' => DateFormatter::stringFormat($group->studying_start_date),
                    'time_end' => DateFormatter::stringFormat($group->studying_end_date),
                ],
                'lessons' => $lessonsArr
            ]
        ];

        $registrationOrderTE = new ScheduleTemplateEngine();
        $savedDocumentData = $registrationOrderTE->saveDocument($data);
        $savedDocumentData['group_id'] = $group->id;

        $savedDocument = new ScheduleDocument($savedDocumentData);
        $savedDocument->save();

        return $savedDocument;
    }
}
