<?php

namespace App\Components\Courses\BusinessLayer;

use App\Common\Exceptions\KnownException;
use App\Components\Courses\Models\Course;
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

            $group = Course::create($data);

            DB::commit();
        }
        catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return Read::byId((string) $group->id);
    }
}
