<?php

namespace App\Common\Helpers;

use App\Components\Groups\Models\Group;
use Carbon\Carbon;

class GroupHelper
{
    public static function GenerateGroupName(string $category): string
    {
        $groups =  Group::query()
            ->leftJoin(
                'public.courses',
                'public.groups.course_id',
                '=',
                'public.courses.id'
            )
            ->select(
                'public.groups.id AS id'
            )
            ->where(
                'public.courses.category', '=', $category
            )
            ->get();

        $groupsCount = $groups->count() + 1;
        if ((int)($groupsCount / 10) == 0) {
            $groupsCount = "0$groupsCount";
        }
        $year =  substr(Carbon::now()->year, -2);
        return "{$category}{$year}-$groupsCount";
    }
}
