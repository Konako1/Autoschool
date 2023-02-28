<?php

namespace App\Components\Modules\BusinessLayer;

use App\Components\Modules\Models\Module;
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
