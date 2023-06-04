<?php

namespace App\Components\Groups\BusinessLayer\Validations;

use App\Components\Courses\Models\Course;
use App\Components\Lessons\Models\Lesson;
use App\Components\Timings\Models\Timing;
use App\Components\Weekdays\Models\Weekday;
use Carbon\Carbon;

class CalendarValidation
{
    private static function getGroupsInRange(string $courseId, string $studyingStartDate): array {
        $studyingStartDate = Carbon::createFromFormat('Y-m-d', $studyingStartDate);
        $lessons = Lesson::all();
        $course = Course::find($courseId);
        $modules = $course->modules()->get();
        $lessonsCount = 2;
        foreach ($modules as $module) {
            $lessonsCount += $module->hours;
        }

        $weeks = $lessonsCount % 3 == 0 ? (int)($lessonsCount / 3) : (int)($lessonsCount / 3) + 1;
        $studyingEndDate = $studyingStartDate->copy();
        $studyingEndDate->addWeeks($weeks);

        $lessonsInRange = $lessons
            ->where('date', '>', $studyingStartDate)
            ->where('date', '<', $studyingEndDate)
            ->all();

        $groups = [];
        foreach ($lessonsInRange as $lesson) {
            if (!in_array($lesson->group(), $groups))
                $groups[] = $lesson->group();
        }
        return $groups;
    }

    public static function getAvailableTimings(string $courseId, string $studyingStartDate): array {
        $groupsInRange = self::getGroupsInRange($courseId, $studyingStartDate);
        $timingIds = Timing::all()->pluck('id')->toArray();
        $weekdayIds = Weekday::all()->pluck('id')->toArray();

        $timings = [];
        foreach ($timingIds as $timing) {
            $timings[$timing] = $weekdayIds;
        }

        foreach ($groupsInRange as $group) {
            foreach ($timings as $timing => $weekdays) {
                if ($timing == $group->timing_id) {
                    $groupWeekdays = $group->weekdays()->get()->pluck('id')->toArray();
                    foreach ($groupWeekdays as $weekday) {
                        $key = array_search($weekday, $timings[$timing]);
                        if ($key !== false)
                            unset($timings[$timing][$key]);
                    }
                    if ($timings[$timing] == null)
                        unset($timings[$timing]);
                    break;
                }
            }
        }

        return array_keys($timings);
    }

    public static function getAvailableWeekdays(string $courseId, string $studyingStartDate, string $timingId = null): array {
        $groupsInRange = self::getGroupsInRange($courseId, $studyingStartDate);

        $groups = [];
        foreach ($groupsInRange as $group) {
            if ($group->timing_id == $timingId && !in_array($group, $groups)) {
                $groups[] = $group;
            }
        }

        $availableWeekdays = Weekday::all()->pluck('id')->toArray();
        foreach ($groups as $group) {
            $weekdays = $group->weekdays()->get()->pluck('id')->toArray();
            foreach ($weekdays as $weekday) {
                $weekdayInArray = array_search($weekday, $availableWeekdays);
                if ($weekdayInArray !== false) {
                    array_splice($availableWeekdays, $weekdayInArray, 1);
                }
            }
        }

        return $availableWeekdays;
    }
}
