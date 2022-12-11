<?php

/**
 * @file
 * Ресурс для возврата успешного ответа
 */

namespace App\Common\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SuccessResource extends JsonResource
{
    /**
     * Убираем обертку
     */
    public static $wrap = '';

    /**
     * Сообщение для вывода пользователю
     * @var string
     */
    protected $message;

    /**
     * Массив с полезной нагрузкой
     * @var array
     */
    protected $data;

    /**
     * Общее количество записей
     * @var int
     */
    protected $total;

    /**
     * SuccessResource конструктор.
     * @param string $msg - сообщение для вывода пользователю
     * @param array $data - полезная нагрузка
     */
    public function __construct(array $data = [], string $msg = null)
    {
        $this->message = $msg ?? trans('Запрос выполнен успешно');
        $this->data = $data;
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
            'success'   => true,
            'message'   => $this->message,
            'payload'   => $this->data,
        ];
    }
}
