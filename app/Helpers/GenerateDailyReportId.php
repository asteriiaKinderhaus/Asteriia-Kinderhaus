<?php

namespace App\Helpers;

use App\Models\DailyReport;
use Illuminate\Support\Facades\DB;

class GenerateDailyReportId
{
    public static function dailyReportID()
    {

        $prefix = 'DRP' . now()->format('Ymd');

        return DB::transaction(function () use ($prefix) {
            $last = DailyReport::where('id', 'like', $prefix . '%')
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
