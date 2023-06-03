<?php

namespace App\Common\Helpers;

use App\Components\Groups\Models\Group;
use App\Components\Lessons\Models\Lesson;
use App\Components\Modules\Models\Module;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class LecturesGenerator
{
    public static function generate(Group $group) {
        $weekdays = $group->weekdays()->get();
        $modules = $group->course()->modules()->get();
        $lastDate = Carbon::createFromFormat('Y-m-d', $group->studying_start_date);

        foreach ($modules as $module) {
            $lessonsCount = $module->hours / 2;

            for ($i = 0; $i < $lessonsCount; $i++) {
                Lesson::create([
                    'title'         => $module->name . ' ' . ($i + 1),
                    'date'          => $lastDate->toDate(),
                    'module_id'     => $module->id,
                    'group_id'      => $group->id,
                ]);
                $lastDate->addDays(self::calculateDaysToAdd($lastDate, $weekdays));
            }
        }

        $examModules = Module::where('metadata', '=', 'exam')->get();
        Lesson::create([
            'title'         => $examModules[0]->name,
            'date'          => $lastDate->toDate(),
            'module_id'     => $examModules[0]->id,
            'group_id'      => $group->id,
        ]);

        $lastDate->addDays(self::calculateDaysToAdd($lastDate, $weekdays));
        $lastLesson = Lesson::create([
            'title'         => $examModules[1]->name,
            'date'          => $lastDate->toDate(),
            'module_id'     => $examModules[1]->id,
            'group_id'      => $group->id,
        ]);
        $group->studying_end_date = $lastLesson->date;
        $group->update();
    }

    private static function calculateDaysToAdd(Carbon $date, Collection $weekdays): int {
        $dateWeekday = $date->weekday();
        $weekdaysCount = $weekdays->count();
        foreach ($weekdays as $key => $weekday) {
            if ($weekday->order == $dateWeekday) {
                if ($key == $weekdaysCount - 1) {
                    $newWeekdayOrder = $weekdays->first()->order;
                    return 7 + $newWeekdayOrder - $dateWeekday;
                }
                else {
                    $newWeekdayOrder = $weekdays[$key + 1]->order;
                    return $newWeekdayOrder - $dateWeekday;
                }
            }
        }
        throw new \OutOfRangeException("День недели не был найден в массиве дней недели");
    }
}
