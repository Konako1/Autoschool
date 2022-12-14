<?php

namespace App\Components\Groups\BusinessLayer;

use App\Components\Groups\Models\Group;
use Exception;
use Illuminate\Support\Facades\DB;

class Update
{
    /**
     * @throws Exception
     */
    public static function one(array $data, string $id): array
    {
        $group = Group::find($id);
        if (!$group) {
            throw new Exception("Группа $id не найдена");
        }

        try {
            DB::beginTransaction();

            $newGroup = $group->update($data);
            DB::commit();
        }
        catch (Exception $e) {
            DB::rollBack();
            throw new Exception('Чето не так пошло');
        }

        return Read::byId((string) $group->id);
    }
}
