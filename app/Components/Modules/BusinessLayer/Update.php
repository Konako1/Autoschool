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
    public static function one(array $data, string $id, string $instructor_id): array
    {
        $module = Module::find($id);
        if (!$module) {
            throw new DataBaseException("Группа с id $id не найдена");
        }

        $instructor = Instructor::find($instructor_id);
        if ($instructor->is_practician) {
            throw new KnownException('Инструктором в группе не может быть практик');
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
