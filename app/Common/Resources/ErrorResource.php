<?php

namespace App\Common\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ErrorResource extends JsonResource
{
    /**
     * Убираем обертку
     */
    public static $wrap = '';

    /**
     * Текст ошибки для вывода пользователю
     * @var string данные
     */
    protected $error;

    /**
     * Массив с детальной информацией об ошибках (для разработчика)
     * @var array
     */
    protected $errors;

    /**
     * ErrorResource constructor.
     * @param string $error - сообщение об ошибке
     * @param array $errors - массив с детальной информацией об ошибках
     *
     */
    public function __construct(array $errors = [], string $error = '')
    {
        $this->error = $error;
        $this->errors = $errors;
    }

    /**
     * Выводит полученные данные в массиве
     *
     * @param $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'success'   => false,
            'message'   => $this->error ?? trans('Ошибка выполнения запроса'),
            'errors'    => $this->errors,
        ];
    }
}
