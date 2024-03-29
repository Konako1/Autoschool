<?php

namespace Database\Seeders;

use App\Components\Groups\Models\Group;
use App\Components\Instructors\Models\Instructor;
use App\Components\Students\Models\Student;
use Faker\Factory;
use Illuminate\Database\Seeder;

class StudentsSeeder extends Seeder
{
    public function run()
    {
        $names = ["Алексей", "Артём", "Вадим", "Владимир", "Валентин", "Данил", "Денис", "Дмитрий", "Егор", "Кирилл", "Леонид", "Максим", "Матвей", "Никита", "Олег", "Павел", "Пётр", "Роман", "Сергей", "Станислав"];
        $families = ["Иванов", "Васильев", "Петров", "Смирнов", "Михайлов", "Фёдоров", "Соколов", "Яковлев", "Попов", "Андреев", "Алексеев", "Александров", "Лебедев", "Григорьев", "Степанов", "Семёнов", "Павлов", "Богданов", "Николаев", "Дмитриев", "Егоров", "Волков", "Кузнецов", "Никитин", "Соловьёв", "Тимофеев", "Орлов", "Афанасьев", "Филиппов", "Сергеев", "Захаров", "Матвеев", "Виноградов", "Кузьмин", "Максимов", "Козлов", "Ильин", "Герасимов", "Марков", "Новиков", "Морозов", "Романов", "Осипов", "Макаров", "Зайцев", "Беляев", "Гаврилов", "Антонов", "Ефимов", "Леонтьев", "Давыдов", "Гусев", "Данилов", "Киселёв", "Сорокин", "Тихомиров", "Крылов", "Никифоров", "Кондратьев", "Кудрявцев", "Борисов", "Жуков", "Воробьёв", "Щербаков", "Поляков", "Савельев", "Шмидт", "Трофимов", "Чистяков", "Баранов", "Сидоров", "Соболев", "Карпов", "Белов", "Миллер", "Титов", "Львов", "Фролов", "Игнатьев", "Комаров", "Прокофьев", "Быков", "Абрамов", "Голубев", "Пономарёв", "Покровский", "Мартынов", "Кириллов", "Шульц", "Миронов", "Фомин", "Власов", "Троицкий", "Федотов", "Назаров", "Ушаков", "Денисов", "Константинов", "Воронин", "Наумов"];
        $patronymics = ["Фёдорович", "Егорович", "Никитич", "Васильевич", "Артёмович", "Иванович", "Игоревич", "Андреевич", "Романович", "Ильич", "Даниилович", "Тимурович", "Максимович"];
        $faker = Factory::create();
        $groups = Group::all();
        $instructors = Instructor::where('is_practician', '=', true)->get();

        for ($i = 0; $i < 20; $i++) {
            $group = $groups->random();
            Student::create([
                'group_id'          => $group->id,
                'name'              => $names[rand(0, count($names) - 1)],
                'surname'           => $families[rand(0, count($families) - 1)],
                'patronymic'        => $patronymics[rand(0, count($patronymics) - 1)],
                'birthday'          => $faker->unique()->dateTime,
                'photo_path'        => $faker->numerify('photo###'),
                'phone'             => $faker->numerify('8##########'),
                'address'           => $faker->address,
                'instructor_id'     => $instructors->where('category_id', '=', $group->course()->category()->id)->random()->id,
            ]);
        }
    }
}
