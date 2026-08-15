<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyReportMeal extends Model
{
    protected $table = 'daily_report_meals';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'daily_report_id',
        'meal_id',
        'food_status',
        'assistance',
    ];

    public function dailyReport()
    {
        return $this->belongsTo(
            DailyReport::class,
            'daily_report_id',
            'id'
        );
    }

    public function meal()
    {
        return $this->belongsTo(
            Meal::class,
            'meal_id',
            'id'
        );
    }
}
