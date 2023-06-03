<?php

namespace Database\Seeders;

use App\Common\Helpers\GroupHelper;
use App\Components\Courses\Models\Course;
use App\Components\Groups\Models\Group;
use App\Components\Groups\Models\GroupWeekday;
use App\Components\Timings\Models\Timing;
use App\Components\Weekdays\Models\Weekday;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class GroupsSeeder extends Seeder
{
    public function run()
    {
        $courses = Course::all();
        $timings = Timing::all();

        $course = $courses->random();
        $group = Group::create([
            'name'                  => GroupHelper::GenerateGroupName($course->category()->id),
            'studying_start_date'   => '2023-05-15',
            'studying_end_date'     => Carbon::createFromTimestamp(0),
            'course_id'             => $course->id,
            'timing_id'             => $timings->where('start', '=', 10)->first()->id,
        ]);
        $this->seedGroupWeekday($group, [1, 3, 5]);

        $course = $courses->random();
        $group = Group::create([
            'name'                  => GroupHelper::GenerateGroupName($course->category()->id),
            'studying_start_date'   => '2023-06-22',
            'studying_end_date'     => Carbon::createFromTimestamp(0),
            'course_id'             => $course->id,
            'timing_id'             => $timings->where('start', '=', 10)->first()->id,
        ]);
        $this->seedGroupWeekday($group, [2, 4, 6]);

        $course = $courses->random();
        $group = Group::create([
            'name'                  => GroupHelper::GenerateGroupName($course->category()->id),
            'studying_start_date'   => '2023-07-01',
            'studying_end_date'     => Carbon::createFromTimestamp(0),
            'course_id'             => $course->id,
            'timing_id'             => $timings->where('start', '=', 14)->first()->id,
        ]);
        $this->seedGroupWeekday($group, [2, 4, 6]);
    }

    private function seedGroupWeekday(Group $group, array $weekdayOrders)
    {
        foreach ($weekdayOrders as $order) {
            GroupWeekday::create([
                'group_id' => $group->id,
                'weekday_id' => Weekday::where('order', '=', $order)->first()->id
            ]);
        }
    }
}
