<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyReportSelfHelp extends Model
{
    protected $table = 'daily_report_self_helps';

    protected $fillable = [
        'id',
        'daily_report_id',
        'self_help_id',
        'assistance',
    ];

    public $incrementing = false;

    protected $keyType = 'string';

    public function selfHelp()
    {
        return $this->belongsTo(
            SelfHelp::class,
            'self_help_id',
            'id'
        );
    }

    public function dailyReport()
    {
        return $this->belongsTo(
            DailyReport::class,
            'daily_report_id',
            'id'
        );
    }
}
