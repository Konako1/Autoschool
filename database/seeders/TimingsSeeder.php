<?php

namespace Database\Seeders;

use App\Components\Timings\Models\Timing;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TimingsSeeder extends Seeder
{
    public function run()
    {
        Timing::create([
            'start' => Carbon::createFromTime(10),
            'end' => Carbon::createFromTime(11, 30),
            'time_interval' => '10:00 - 11:30',
            'type' => 'утренняя',
        ]);
        Timing::create([
            'start' => Carbon::createFromTime(12),
            'end' => Carbon::createFromTime(13, 30),
            'time_interval' => '12:00 - 13:30',
            'type' => 'дневная',
        ]);
        Timing::create([
            'start' => Carbon::createFromTime(14),
            'end' => Carbon::createFromTime(15, 30),
            'time_interval' => '14:00 - 15:30',
            'type' => 'дневная',
        ]);
        Timing::create([
            'start' => Carbon::createFromTime(16),
            'end' => Carbon::createFromTime(17, 30),
            'time_interval' => '16:00 - 17:30',
            'type' => 'дневная',
        ]);
        Timing::create([
            'start' => Carbon::createFromTime(18),
            'end' => Carbon::createFromTime(19, 30),
            'time_interval' => '18:00 - 19:30',
            'type' => 'вечерняя',
        ]);
    }
}
