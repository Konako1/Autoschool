<?php

namespace App\Components\Modules\BusinessLayer;

use App\Common\Exceptions\KnownException;
use App\Components\Instructors\Models\Instructor;
use App\Components\Modules\Models\Module;
use Exception;
use Illuminate\Support\Facades\DB;

class Create
{
    /**
     * @throws Exception
     */
    public static function one(array $data, string $instructor_id): array
    {
        $instructor = Instructor::find($instructor_id);
        if ($instructor->is_practician) {
            throw new KnownException('Инструктором в группе не может быть практик');
        }

        try {
            DB::beginTransaction();

            $module = Module::create($data);

            DB::commit();
        }
        catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return Read::byId((string) $module->id);
    }
}
