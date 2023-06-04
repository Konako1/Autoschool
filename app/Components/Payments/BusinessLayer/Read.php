<?php

namespace App\Components\Payments\BusinessLayer;

use App\Common\Exceptions\DataBaseException;
use App\Common\Services\RecordsList;
use App\Components\Payments\Models\Payment;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class Read
{
    private static function getBaseQuery(): Builder
    {
        return Payment::query()
            ->leftJoin(
                'public.students',
                'public.payments.student_id',
                '=',
                'public.students.id'
            )
            ->select(
                'public.payments.id AS id',
                'value',
                'date',
                'student_id',
                'public.students.group_id AS student_group_id',
                'public.students.name AS student_name',
                'public.students.surname AS student_surname',
                'public.students.patronymic AS student_patronymic',
                'public.students.birthday AS student_birthday',
                'public.students.photo_path AS student_photo_path',
                'public.students.phone AS student_phone',
                'public.students.address AS student_address',
            )
            ->orderByDesc(
                'public.payments.updated_at'
            );
    }

    /**
     * Базовый запрос по id студента
     *
     * @param string $studentId
     *
     * @return Builder
     */
    private static function getBaseQueryByStudentId(string $studentId): Builder
    {
        return self::getBaseQuery()
            ->where('student_id', $studentId);
    }

    /**
     * Базовый запрос по id группы
     *
     * @param string $groupId
     *
     * @return Builder
     */
    private static function getBaseQueryByGroupId(string $groupId): Builder
    {
        return self::getBaseQuery()
            ->where('students.group_id', $groupId);
    }

    /**
     * Получить запись по id
     *
     * @param string $studentId - id студента
     * @param string $id - id записи
     *
     * @return array
     * @throws Exception
     */
    public static function byId(string $studentId, string $id): array
    {
        $record = self::getBaseQueryByStudentId($studentId)
            ->find($id);

        // проверка: если запись не найдена
        if (!$record) {
            throw new DataBaseException("id $id не существует."); //DataBaseException(Error::getMessage(2002, "id", $id));
        }

        return $record->toArray();
    }

    /**
     * Получить список всех записей
     *
     * @param $params
     *
     * @return Collection
     */
    public static function all($params): Collection
    {
        $query = new RecordsList(self::getBaseQuery(), $params);
        return $query->getRecords();
    }

    /**
     * Получить список всех записей по студенту
     *
     * @param $studentId
     * @param $params
     *
     * @return Collection
     */
    public static function allByStudentId($studentId, $params): Collection
    {
        $query = new RecordsList(self::getBaseQueryByStudentId($studentId), $params);
        return $query->getRecords();
    }

    /**
     * Получить список всех записей по группе
     *
     * @param $groupId
     * @param $params
     * @return int
     */
    public static function debtByGroupId($groupId, $params): int
    {
        $query = new RecordsList(self::getBaseQueryByGroupId($groupId), $params);
        $records = $query->getRecords();
        $coursePrice = (float)$records->first()->student()->group()->course()->price;
        $valuesArr = $records
            ->pluck('value')
            ->all();
        $dept = 0.0;
        foreach ($valuesArr as $value) {
            $dept += $coursePrice - (int) $value;
        }
        return round($dept);
    }

    /**
     * @param $params
     *
     * @return int
     */
    public static function count($params): int
    {
        $query = new RecordsList(self::getBaseQuery(), $params);
        return $query->countTotal();
    }

    /**
     * Получить удаленную запись по id
     *
     * @param string $studentId
     * @param string $id
     *
     * @return array
     */
    public static function trashed(string $studentId, string $id): array
    {
        return self::getBaseQueryByStudentId($studentId)
            ->withTrashed()
            ->find($id)
            ->toArray()
        ;
    }
}
