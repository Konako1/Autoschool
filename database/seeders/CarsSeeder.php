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
            'reg_number'    => 'A 666 BC',
            'gearbox_type'  => 'auto',
        ]);
        Car::create([
            'name'          => 'Lada Largus',
            'reg_number'    => 'O 727 PP',
            'gearbox_type'  => 'auto',
        ]);
        Car::create([
            'name'          => 'Toyota Corolla',
            'reg_number'    => 'E 228 EE',
            'gearbox_type'  => 'manual',
        ]);
        Car::create([
            'name'          => 'Bugatti Veyron',
            'reg_number'    => 'A 999 KB',
            'gearbox_type'  => 'auto',
        ]);
        Car::create([
            'name'          => 'Lada Priora',
            'reg_number'    => 'C 322 MO',
            'gearbox_type'  => 'manual',
        ]);
    }
}
