<?php

namespace Database\Seeders;

use App\Components\Cars\Models\Car;
use App\Components\Instructors\Models\Instructor;
use Illuminate\Database\Seeder;

class InstructorsSeeder extends Seeder
{
    public function run()
    {
        $cars = Car::all();

        Instructor::create([
            'job'                           => 'Инструктор по вождению',
            'education'                     => 'Высшее',
            'certificate'                   => 'ЗС-14 № 1181 от 08.12.2014',
            'driver_certificate'            => '72 ТМ № 039642',
            'driver_certificate_category'   => 'ABCDE',
            'car_id'                        => $cars->random()->id,
            'name'                          => 'Иван',
            'surname'                       => 'Худасов',
            'patronymic'                    => 'Павлович',
            'photo_path'                    => 'photo1',
            'phone'                         => '89504838737',
            'is_practician'                 => true,
        ]);

        Instructor::create([
            'job'                           => 'Инструктор по практике',
            'education'                     => 'Высшее',
            'certificate'                   => 'ЗС-24 № 1337 от 23.11.2015',
            'driver_certificate'            => '72 ТМ № 034412',
            'driver_certificate_category'   => 'ABE',
            'car_id'                        => $cars->random()->id,
            'name'                          => 'Николай',
            'surname'                       => 'Новицкий',
            'patronymic'                    => 'Какойтотамович',
            'photo_path'                    => 'photo2',
            'phone'                         => '89263748923',
            'is_practician'                 => true,
        ]);

        Instructor::create([
            'job'                           => 'Инструктор по безопасности',
            'education'                     => 'Среднее',
            'certificate'                   => 'ЗС-34 № 1234 от 23.11.2016',
            'driver_certificate'            => '72 ТМ № 036487',
            'driver_certificate_category'   => 'A',
            'name'                          => 'Топычканов',
            'surname'                       => 'Денис',
            'patronymic'                    => 'Какойтотамович',
            'photo_path'                    => 'photo3',
            'phone'                         => '89736458254',
            'is_practician'                 => false,
        ]);
    }
}
