<?php

namespace Database\Seeders;

use App\Components\Cars\Models\Car;
use Illuminate\Database\Seeder;

class CarsSeeder extends Seeder
{
    public function run()
    {
        Car::create([
            'name'          => 'Lada Largus',
            'reg_number'    => 'O 727 PP',
            'gearbox_type'  => 'auto',
            'category_id'   => 3
        ]);
        Car::create([
            'name'          => 'Toyota Corolla',
            'reg_number'    => 'E 228 EE',
            'gearbox_type'  => 'manual',
            'category_id'   => 3
        ]);
        Car::create([
            'name'          => 'Bugatti Veyron',
            'reg_number'    => 'A 999 KB',
            'gearbox_type'  => 'auto',
            'category_id'   => 4
        ]);
        Car::create([
            'name'          => 'Икарус',
            'reg_number'    => 'AB 888',
            'gearbox_type'  => 'manual',
            'category_id'   => 10
        ]);
    }
}
