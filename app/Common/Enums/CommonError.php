<?php

namespace App\Common\Enums;

class CommonError
{
    public static function errorGetListRecords(): string
    {
        return "Ошибка получения списка записей. ";
    }

    public static function errorGetRecord(): string
    {
        return "Ошибка получения записи. ";
    }

    public static function errorCreateRecord(): string
    {
        return "Ошибка создания записи. ";
    }

    public static function errorUpdateRecord(): string
    {
        return "Ошибка обновления записи. ";
    }

    public static function errorDeleteRecord(): string
    {
        return "Ошибка удаления записи. ";
    }

    public static function errorDownloadRecord(): string
    {
        return "Ошибка загрузки записи. ";
    }

    public static function errorSendRecord(): string
    {
        return "Ошибка отправки записи. ";
    }

    public static function errorValidateRecord(): string
    {
        return "Ошибка проверки записи. ";
    }

    public static function errorResetRecord(): string
    {
        return "Ошибка сброса записи. ";
    }

    public static function errorUpdateRecords(): string
    {
        return "Ошибка обновления записей. ";
    }

    public static function errorCheckLinks(): string
    {
        return "Ошибка проверки связей. ";
    }

    public static function errorCreateFactoryRecords(): string
    {
        return "Ошибка создания фабрики записей. ";
    }

    public static function errorGetStatusRecord(): string
    {
        return "Ошибка создания фабрики записей. ";
    }
}
