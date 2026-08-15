<?php

namespace App\Helpers;

use App\Models\DailyReportMeal;

class GenerateMealReportID
{
    public static function mealReport()
    {
        $prefix = 'MRP' . now()->format('Ymd');

        $last = DailyReportMeal::where('id', 'like', $prefix . '%')
            ->orderByDesc('id')
            ->first();

        $number = $last
            ? (int) substr($last->id, -3) + 1
            : 1;

        return $prefix . str_pad($number, 3, '0', STR_PAD_LEFT);
    }
}
