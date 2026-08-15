<?php

namespace App\Helpers;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\DailyReportStimulation;

class Generate_ID
{

    public static function generateId(
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

    public static function generateReportStimulationID()
    {
        $prefix = 'DRS' . now()->format('Ymd');

        return DB::transaction(function () use ($prefix) {
            $last = DailyReportStimulation::where('id', 'like', $prefix . '%')
                ->orderByDesc('id')
                ->lockForUpdate()
                ->first();

            if (!$last) {
                $urut = 1;
            } else {
                $urut = (int) substr($last->id, -3) + 1;
            }

            return $prefix . str_pad($urut, 3, '0', STR_PAD_LEFT);
        });
    }
}
