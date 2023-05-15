<?php

namespace App\Components\Documents\WaybillDocuments\BusinessLayer;

use App\Common\DocxTemplateEngine\Templates\WaybillTemplateEngine;
use App\Components\Documents\WaybillDocuments\Models\WaybillDocument;
use App\Components\Students\Models\Student;

class Create
{
    public static function one(string $studentId): WaybillDocument
     {
         $student = Student::find($studentId);
         $group = $student->group();
         $instructor = $student->instructor();
         $car = $instructor->car();

         $data = [
             'data' => [
                 'group_number' => $group->name,
                 'instructor_fio' => "$instructor->surname $instructor->name $instructor->patronymic",
                 'student' => [
                     'surname' => $student->surname,
                     'name' => $student->name,
                     'patronymic' => $student->patronymic,
                 ],
                 'car' => [
                     'name' => $car->name,
                     'reg_number' => $car->reg_number,
                 ]
             ]
         ];

         $waybillTE = new WaybillTemplateEngine();
         $savedDocumentData = $waybillTE->saveDocument($data);
         $savedDocumentData['student_id'] = $student->id;

         $savedDocument = new WaybillDocument($savedDocumentData);
         $savedDocument->save();

         return $savedDocument;
     }
}
