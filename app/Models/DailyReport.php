<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\DailyReportSelfHelp;
use App\Models\Student;


class DailyReport extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'daily_reports';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [

        'id',

        'report_date',

        'student_id',

        'facilitator_id',

        'class_id',

        'additional_note',

        'facilitator_activity',

        'parent_activity',

        'parent_note',

        'status',

    ];

    protected $casts = [

        'report_date' => 'date',

        'status' => 'boolean',

    ];

    public function student()
    {
        return $this->belongsTo(
            Student::class,
            'student_id',
            'id'
        );
    }

    public function facilitator()
    {
        return $this->belongsTo(
            Facilitator::class,
            'facilitator_id',
            'id'
        );
    }

    public function schoolClass()
    {
        return $this->belongsTo(
            SchoolClass::class,
            'class_id',
            'id'
        );
    }

    public function meals()
    {
        return $this->hasMany(
            DailyReportMeal::class,
            'daily_report_id',
            'id'
        );
    }

    public function selfHelps()
    {
        return $this->hasMany(
            DailyReportSelfHelp::class,
            'daily_report_id',
            'id'
        );
    }

    /**
     * Relasi ke hasil stimulasi
     */
    public function stimulations()
    {
        return $this->hasMany(
            DailyReportStimulation::class,
            'daily_report_id',
            'id'
        );
    }
}
