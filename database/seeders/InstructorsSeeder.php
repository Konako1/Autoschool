<?php

namespace Database\Seeders;

use App\Components\Cars\Models\Car;
use App\Components\Categories\Models\Category;
use App\Components\Instructors\Models\Instructor;
use Illuminate\Database\Seeder;

class InstructorsSeeder extends Seeder
{
    public function run()
    {
        $cars = Car::all();
        $categories = Category::all();

        $category = $categories->find(3);
        Instructor::create([
            'job'                           => 'Инструктор по вождению',
            'education'                     => 'Высшее',
            'certificate'                   => 'ЗС-14 № 1181 от 08.12.2014',
            'driver_certificate'            => '72 ТМ № 039642',
            'category_id'                   => $category->id,
            'car_id'                        => $cars->where('category_id', '=', $category->id)->random()->id,
            'name'                          => 'Иван',
            'surname'                       => 'Худасов',
            'patronymic'                    => 'Павлович',
            'photo_path'                    => 'photo1',
            'phone'                         => '89504838737',
            'is_practician'                 => true,
        ]);

        Instructor::create([
            'job'                           => 'Лектор',
            'education'                     => 'Высшее',
            'certificate'                   => 'ЗС-16 № 1337 от 07.11.2014',
            'driver_certificate'            => '72 ТМ № 228012',
            'category_id'                   => $category->id,
            'name'                          => 'Евгений',
            'surname'                       => 'Филимонов',
            'patronymic'                    => 'Евгеньевич',
            'photo_path'                    => 'photo4',
            'phone'                         => '89221237891',
            'is_practician'                 => false,
        ]);

        $category = $categories->find(4);
        Instructor::create([
            'job'                           => 'Инструктор по вождению',
            'education'                     => 'Высшее',
            'certificate'                   => 'ЗС-14 № 7958 от 18.11.2004',
            'driver_certificate'            => '72 ТМ № 238742',
            'category_id'                   => $category->id,
            'car_id'                        => $cars->where('category_id', '=', $category->id)->random()->id,
            'name'                          => 'Кирилл',
            'surname'                       => 'Кориков',
            'patronymic'                    => 'Александрович',
            'photo_path'                    => 'photo5',
            'phone'                         => '82637482234',
            'is_practician'                 => true,
        ]);

        Instructor::create([
            'job'                           => 'Лектор',
            'education'                     => 'Высшее',
            'certificate'                   => 'ЗС-23 № 8675 от 17.08.2009',
            'driver_certificate'            => '72 ТМ № 908767',
            'category_id'                   => $category->id,
            'name'                          => 'Филипп',
            'surname'                       => 'Киркоров',
            'patronymic'                    => 'Евгеньевич',
            'photo_path'                    => 'photo6',
            'phone'                         => '89225679275',
            'is_practician'                 => false,
        ]);

        $category = $categories->find(10);
        Instructor::create([
            'job'                           => 'Инструктор по практике',
            'education'                     => 'Высшее',
            'certificate'                   => 'ЗС-24 № 1337 от 23.11.2015',
            'driver_certificate'            => '72 ТМ № 034412',
            'category_id'                   => $category->id,
            'car_id'                        => $cars->where('category_id', '=', $category->id)->random()->id,
            'name'                          => 'Николай',
            'surname'                       => 'Новицкий',
            'patronymic'                    => 'Какойтотамович',
            'photo_path'                    => 'photo2',
            'phone'                         => '89263748923',
            'is_practician'                 => true,
        ]);

        Instructor::create([
            'job'                           => 'Лектор',
            'education'                     => 'Среднее',
            'certificate'                   => 'ЗС-34 № 1234 от 23.11.2016',
            'driver_certificate'            => '72 ТМ № 036487',
            'category_id'                   => $category->id,
            'name'                          => 'Топычканов',
            'surname'                       => 'Денис',
            'patronymic'                    => 'Какойтотамович',
            'photo_path'                    => 'photo3',
            'phone'                         => '89736458254',
            'is_practician'                 => false,
        ]);
    }
}
