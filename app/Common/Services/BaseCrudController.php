<?php

namespace App\Common\Services;

use Illuminate\Http\Request;

class BaseCrudController
{
    /**
     * Метод получает из request и подготавливает параметры для получения списка записей с помощью сервиса FSOP:
     * фильтрация, пагинация, сортировка, поиск
     *
     * @param Request $request
     *
     * @return array
     */
    public function getParams(Request $request): array {
        $params = $request->all([
            'page',
            'limit',
        ]);

        if ($request->has('search')) {
            $params['search'] = json_decode($request->get('search'), true);
        }

        $filters = $request->has('filter') ? $request->get('filter') : [];

        foreach ($filters as $filter => $value) {
            $params['filter'][$filter] = json_decode($value, true);
        }

        $orders = $request->has('orders') ? $request->get('orders') : [];
        foreach ($orders as $order) {
            $params['orders'][] = json_decode($order, true);
        }

        return $params;
    }

    /**
     * Возвращает данные из реквеста в виде ассоциативного массива
     *
     * @param Request $request
     *
     * @return array
     */
    public function getData(Request $request): array
    {
        $data = $request->getContent();
        return json_decode($data, true)['data'];
    }
}
