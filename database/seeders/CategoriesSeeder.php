<?php

namespace Database\Seeders;

use App\Components\Categories\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    public function run()
    {
        Category::create([
            'name'          => 'A',
            'description'   => 'Мотоциклы',
            'has_gearbox'  => false,
        ]);

        Category::create([
            'name'          => 'A1',
            'description'   => 'Легкие мотоциклы',
            'has_gearbox'  => false,
        ]);

        Category::create([
            'name'          => 'B',
            'description'   => 'Легковые автомобили, небольшие грузовики',
            'has_gearbox'  => true,
        ]);

        Category::create([
            'name'          => 'BE',
            'description'   => 'Легковые автомобили с прицепом',
            'has_gearbox'  => true,
        ]);

        Category::create([
            'name'          => 'B1',
            'description'   => 'Трициклы, Квадрациклы',
            'has_gearbox'  => true,
        ]);

        Category::create([
            'name'          => 'C',
            'description'   => 'Грузовые автомобили',
            'has_gearbox'  => true,
        ]);

        Category::create([
            'name'          => 'CE',
            'description'   => 'Грузовые автомобили с прицепом',
            'has_gearbox'  => true,
        ]);

        Category::create([
            'name'          => 'C1',
            'description'   => 'Средние грузовики',
            'has_gearbox'  => true,
        ]);

        Category::create([
            'name'          => 'C1E',
            'description'   => 'Средние грузовики с прицепом',
            'has_gearbox'  => true,
        ]);

        Category::create([
            'name'          => 'D',
            'description'   => 'Автобусы',
            'has_gearbox'  => true,
        ]);

        Category::create([
            'name'          => 'DE',
            'description'   => 'Автобусы с прицепом',
            'has_gearbox'  => true,
        ]);

        Category::create([
            'name'          => 'D1',
            'description'   => 'Небольшие автобусы',
            'has_gearbox'  => true,
        ]);

        Category::create([
            'name'          => 'D1E',
            'description'   => 'Небольшие автобусы с прицепом',
            'has_gearbox'  => true,
        ]);

        Category::create([
            'name'          => 'M',
            'description'   => 'Мопеды',
            'has_gearbox'  => false,
        ]);

        Category::create([
            'name'          => 'Tm',
            'description'   => 'Трамваи',
            'has_gearbox'  => false,
        ]);

        Category::create([
            'name'          => 'Tb',
            'description'   => 'Троллейбусы',
            'has_gearbox'  => false,
        ]);
    }
}
