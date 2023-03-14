<?php

namespace App\Components\Modules\BusinessLayer;

use App\Common\Exceptions\DataBaseException;
use App\Components\Modules\Models\Module;
use App\Components\Students\Models\Student;
use Exception;
use Illuminate\Support\Facades\DB;

class Delete
{
    /**
     * @throws Exception
     */
    public static function one(string $id): array
    {
        $module = Module::find($id);
        if (!$module) {
            throw new DataBaseException("Модуль с id $id не найден");
        }

        try {
            DB::beginTransaction();

            //Lessons::where('module_id', $module->id)->delete();

            $module->delete();

            DB::commit();
        }
        catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return Read::trashed((string) $module->id);
    }
}
