<?php

namespace App\Components\Groups\BusinessLayer;

use App\Components\Groups\Models\Group;
use Exception;
use Illuminate\Support\Facades\DB;

class Delete
{
    /**
     * @throws Exception
     */
    public static function one(string $id): array
    {
        $group = Group::find($id);
        if (!$group) {
            throw new Exception("Группа $id не найдена");
        }

        try {
            DB::beginTransaction();

            $group->delete();

            DB::commit();
        }
        catch (Exception $e) {
            DB::rollBack();
            throw new Exception('Чето не так пошло');
        }

        return Read::trashed((string) $group->id);
    }
}
