<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DailyReportStimulation extends Model
{
    use HasFactory;

    protected $table = 'daily_report_stimulations';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'daily_report_id',
        'stimulation_item_id',
    ];

    /**
     * Relasi ke Daily Report
     */
    public function dailyReport()
    {
        return $this->belongsTo(
            DailyReport::class,
            'daily_report_id',
            'id'
        );
    }

    /**
     * Relasi ke Item Stimulasi
     */
    public function stimulationItem()
    {
        return $this->belongsTo(
            StimulationItem::class,
            'stimulation_item_id',
            'id'
        );
    }
}
