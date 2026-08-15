<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class GenerateId
{
    /**
     * Generate ID
     *
     * Contoh:
     * GenerateId::make(User::class,'USR');
     * Hasil:
     * USR000001
     */
    public static function make(
        string $modelClass,
        string $prefix,
        int $digit = 6
    ): string {

        $model = new $modelClass;

        $table = $model->getTable();

        $pk = $model->getKeyName();

        $last = DB::table($table)
            ->select($pk)
            ->orderByDesc($pk)
            ->lockForUpdate()
            ->first();

        $number = 1;

        if ($last) {

            $number = (int) substr(
                $last->$pk,
                strlen($prefix)
            ) + 1;
        }

        return $prefix .
            str_pad(
                $number,
                $digit,
                '0',
                STR_PAD_LEFT
            );
    }
}
