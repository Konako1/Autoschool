<?php

namespace App\Components\Groups\BusinessLayer;

use App\Components\Groups\Models\Group;
use Exception;
use Illuminate\Support\Facades\DB;

class Create
{
    /**
     * @throws Exception
     */
    public static function one(array $data): array
    {
        try {
            DB::beginTransaction();

            $group = Group::create($data);

            DB::commit();
        }
        catch (Exception $e) {
            DB::rollBack();
            throw new Exception('Чето не так пошло');
        }

        return Read::byId((string) $group->id);
    }
}
