<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StimulationItem extends Model
{
    use HasFactory;

    protected $table = 'stimulation_items';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'category_id',
        'name',
    ];

    /**
     * Relasi ke kategori stimulasi
     */
    public function category()
    {
        return $this->belongsTo(
            StimulationCategory::class,
            'category_id',
            'id'
        );
    }

    /**
     * Relasi ke laporan harian (pivot)
     */
    public function dailyReportStimulations()
    {
        return $this->hasMany(
            DailyReportStimulation::class,
            'stimulation_item_id',
            'id'
        );
    }

    public function stimulation()
    {
        return $this->belongsTo(
            Stimulation::class,
            'stimulation_id',
            'id'
        );
    }
}
