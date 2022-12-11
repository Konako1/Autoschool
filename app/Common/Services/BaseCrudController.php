<?php

namespace App\Common\Services;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

abstract class BaseCrudController extends Controller
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

        $filters = $request->has('filters') ? $request->get('filters') : [];

        foreach ($filters as $filter) {
            $params['filters'][] = json_decode($filter, true);
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
