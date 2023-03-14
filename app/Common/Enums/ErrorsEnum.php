<?php

namespace App\Common\Enums;

class ErrorsEnum
{
    // Общие ошибки
    const DELETE_NON_EXISTS_RECORD      = 'delete_non_exists_record';
    const REQUEST_SUCCESS_BUT_NOTHING   = 'request_success_but_nothing';
    const UPDATE_NON_EXISTS_RECORD      = 'update_non_exists_record';
    const RECORD_NOT_FOUND              = 'record_not_found';
    const abonent_is_not_present        = 'common_error';
    const organization_is_not_present   = 'common_error';
    const data_not_pass_validation      = 'common_error';
    const OPERATOR_HAVE_NO_PARTICIPANTS = 'operator_have_no_participants';
    const INSTANCE_UUID_NOT_VALID       = 'instance_uuid_not_valid';
    // Ошибки правил валидации
    const WRONG_VALIDATION_REGISTRY           = 'wrong_validation_registry';
    const WRONG_VALIDATION_TABLE              = 'wrong_validation_table';
    const WRONG_VALIDATION_COLUMN             = 'wrong_validation_column';
    const ERROR_SAVE_VALIDATION_FILE          = 'error_save_validation_file';
    const ERROR_RESET_RULES_WRONG_ARRAY_RULES = 'error_reset_rules_wrong_array_rules';

    public static function getDescription($key): string
    {
        switch ($key) {
            // Общие ошибки
            case 'delete_non_exists_record':
                return 'Произошла попытка удалить отсутствующую в базе запись';
            case 'update_non_exists_record':
                return 'Произошла попытка обновить отсутствующую в базе запись';
            case 'record_not_found':
                return 'Запись не найдена';
            case 'data_not_pass_validation':
                return 'Данные не прошли валидацию';
            case 'update_data_not_changed':
                return 'Нет новых данных для обновления';
            case 'request_success_but_nothing':
                return 'Запрос выполнен успешно, но не вернул никаких данных.';

            // Ошибки правил валидации
            case 'wrong_validation_registry':
                return 'Передан несуществующий реестр валидации';
            case 'wrong_validation_table':
                return 'Передана несуществующая таблица валидации';
            case 'wrong_validation_column':
                return 'Передана несуществующая колонка таблицы валидации';
            case 'error_save_validation_file':
                return 'Произошла ошибка при сохранении файла валидации';
            case 'error_reset_rules_wrong_array_rules':
                return 'Ошибка при сбросе правил валидации, некорректный массив правил';
        }

        return "Неизвестная ошибка ({$key}). Обратитесь к разработчику";
    }
}
