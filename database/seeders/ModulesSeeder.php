<?php

namespace Database\Seeders;

use App\Components\Instructors\Models\Instructor;
use App\Components\Modules\Models\Module;
use Illuminate\Database\Seeder;

class ModulesSeeder extends Seeder
{
    public function run()
    {
        $instructors = Instructor::where('is_practician', '=', false)->get();

        Module::create([
            'name'          => 'Основы управления транспортными средствами',
            'description'   => '1. Дорожное движение 2. Профессиональная надежность водителя',
            'instructor_id' => $instructors->random()->id,
        ]);

        Module::create([
            'name'          => 'Основы законодательства в сфере дорожного движения',
            'description'   => '1.Законодательство, определяющее правовые основы обеспечения безопасности дорожного движения (ДД) и регулирующее отношения в сфере взаимодействия общества и природы 2.Законодательство, устанавливающее ответственность за нарушения в сфере ДД',
            'instructor_id' => $instructors->random()->id,
        ]);

        Module::create([
            'name'          => 'Первая помощь при дорожно-транспортном происшествии',
            'description'   => '1.Оказание первой помощи при отсутствии сознания, остановке дыхания и кровообращения, практическое занятие 2.Оказание первой помощи при наружных кровотечениях и травмах',
            'instructor_id' => $instructors->random()->id,
        ]);

        Module::create([
            'name'          => 'Организация и выполнение грузовых перевозок',
            'description'   => '1.Нормативные правовые акты, определяющие порядок перевозки грузов автомобильным транспортом 2.Основные показатели работы грузовых автомобилей 3.Организация грузовых перевозок',
            'instructor_id' => $instructors->random()->id,
        ]);

        Module::create([
            'name'          => 'Организация и выполнение пассажирских перевозок',
            'description'   => '1.Нормативное правовое обеспечение пассажирских перевозок автомобильным транспортом 2.Технико-эксплуатационные показатели пассажирского автотранспорта 3.Диспетчерское руководство работой такси на линии',
            'instructor_id' => $instructors->random()->id,
        ]);
    }
}
