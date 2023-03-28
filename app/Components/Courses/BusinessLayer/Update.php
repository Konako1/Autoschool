<?php

namespace App\Components\Courses\BusinessLayer;

use App\Common\Exceptions\DataBaseException;
use App\Common\Exceptions\KnownException;
use App\Components\Courses\Models\Course;
use Exception;
use Illuminate\Support\Facades\DB;

class Update
{
    /**
     * @throws Exception
     */
    public static function one(array $data, string $id): array
    {
        $group = Course::find($id);
        if (!$group) {
            throw new DataBaseException("Группа с id $id не найдена");
        }

        try {
            DB::beginTransaction();

            $group->update($data);

            DB::commit();
        }
        catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return Read::byId((string) $group->id);
    }
}
