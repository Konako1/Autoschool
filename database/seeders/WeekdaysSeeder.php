<?php

namespace Database\Seeders;

use App\Components\Weekdays\Models\Weekday;
use Illuminate\Database\Seeder;

class WeekdaysSeeder extends Seeder
{
    public function run()
    {
        Weekday::create([
            'order'     => 1,
            'day_short' => 'пн',
            'day_long'  => 'понедельник',
        ]);
        Weekday::create([
            'order'     => 2,
            'day_short' => 'вт',
            'day_long'  => 'вторник',
        ]);
        Weekday::create([
            'order'     => 3,
            'day_short' => 'ср',
            'day_long'  => 'среда',
        ]);
        Weekday::create([
            'order'     => 4,
            'day_short' => 'чт',
            'day_long'  => 'четверг',
        ]);
        Weekday::create([
            'order'     => 5,
            'day_short' => 'пт',
            'day_long'  => 'пятница',
        ]);
        Weekday::create([
            'order'     => 6,
            'day_short' => 'сб',
            'day_long'  => 'суббота',
        ]);
    }
}
