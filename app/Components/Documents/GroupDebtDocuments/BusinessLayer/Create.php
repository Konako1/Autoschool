<?php

namespace App\Components\Documents\GroupDebtDocuments\BusinessLayer;

use App\Common\DocxTemplateEngine\Templates\DriverLicenseApplicationTemplateEngine;
use App\Common\DocxTemplateEngine\Templates\GroupDebtTemplateEngine;
use App\Common\Helpers\DateFormatter;
use App\Components\Documents\GroupDebtDocuments\Models\GroupDebtDocument;
use App\Components\Groups\Models\Group;
use Carbon\Carbon;

class Create
{
    public static function one(string $groupId = null): GroupDebtDocument
    {
        if (!isset($groupId))
            $groups = Group::all();
        else
            $groups = Group::where('id', $groupId)->get();

        $students = [];
        $debt = 0;
        foreach ($groups as $group) {
            $course = $group->course();

            foreach ($group->students() as $student) {
                $paymentsSum = $student->payments()->pluck('value')->sum();
                if ($paymentsSum >= $course->price)
                    continue;
                $debt += $course->price - $paymentsSum;
                $students[] = [
                    'number' => count($students) + 1,
                    'group_name' => $group->name,
                    'fio' => "$student->surname $student->name $student->patronymic",
                    'debt' => $course->price - $paymentsSum,
                ];
            }
        }

        $data = [
            'data' => [
                'date_today' => DateFormatter::format(Carbon::now()),
                'students' => $students,
                'debt' => $debt,
            ]
        ];

        $groupDebtTE = new GroupDebtTemplateEngine();
        $savedDocumentData = $groupDebtTE->saveDocument($data);
        $savedDocumentData['group_id'] = $groupId ?? 0;

        $savedDocument = new GroupDebtDocument($savedDocumentData);
        $savedDocument->save();

        return $savedDocument;
    }
}
