<?php

/**
 * @file
 * Ресурс для возврата успешного ответа для коллекции данных
 */

namespace App\Common\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SuccessResourceCollection extends ResourceCollection
{
    /**
     * Убираем обертку
     */
    public static $wrap = '';

    /**
     * Сообщение для вывода пользователю
     *
     * @var string
     */
    protected $message;

    /**
     * Массив с полезной нагрузкой
     *
     * @var array
     */
    protected $data;

    /**
     * Общее количество записей
     *
     * @var int
     */
    protected $total;

    /**
     * SuccessResource конструктор.
     *
     * @param string $msg   - сообщение для вывода пользователю
     * @param array  $data  - полезная нагрузка
     * @param int    $total - общее количество
     */
    public function __construct(array $data = [], int $total = 0, string $msg = null)
    {
        $cnt         = count($data);
        $this->total = ($total && ($total != '0')) ? $total : $cnt;

        $this->message = $cnt > 0
            ? $msg ?? trans('Запрос выполнен успешно')
            : trans('Запрос выполнен успешно, но ничего не вернул');

        $this->data = $data;
    }

    /**
     * Выводит полученные данные в массиве
     *
     * @param $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'success'   => true,
            'message'   => $this->message,
            'items'     => $this->data,
            'total'     => $this->total,
            'errors'    => [],
        ];
    }

}
