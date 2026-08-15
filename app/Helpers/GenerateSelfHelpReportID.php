<?php

namespace App\Helpers;

use App\Models\DailyReportSelfHelp;

class GenerateSelfHelpReportID
{
    public static function selfHelpReport()
    {
        $prefix = 'SRP' . now()->format('Ymd');

        $last = DailyReportSelfHelp::where('id', 'like', $prefix . '%')
            ->orderByDesc('id')
            ->first();

        $number = $last
            ? (int) substr($last->id, -3) + 1
            : 1;

        return $prefix . str_pad($number, 3, '0', STR_PAD_LEFT);
    }
}
