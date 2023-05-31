<?php

namespace App\Components\Modules\BusinessLayer;

use App\Common\Exceptions\DataBaseException;
use App\Common\Exceptions\KnownException;
use App\Components\Instructors\Models\Instructor;
use App\Components\Modules\Models\Module;
use Exception;
use Illuminate\Support\Facades\DB;

class Update
{
    /**
     * @throws Exception
     */
    public static function one(array $data, string $id): array
    {
        $module = Module::find($id);
        if (!$module) {
            throw new DataBaseException("Модуль с id $id не найден");
        }

        try {
            DB::beginTransaction();

            $module->update($data);

            DB::commit();
        }
        catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return Read::byId((string) $module->id);
    }
}
