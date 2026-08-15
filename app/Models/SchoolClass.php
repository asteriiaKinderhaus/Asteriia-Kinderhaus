<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class SchoolClass extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'school_classes';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'name',
        'capacity',
        'status',
    ];

    protected $casts = [

        'status' => 'boolean',

    ];

    public function students()
    {
        return $this->hasMany(
            Student::class,
            'class_id',
            'id'
        );
    }

    public function facilitators()
    {
        return $this->belongsToMany(
            Facilitator::class,
            'facilitator_class',
            'class_id',
            'facilitator_id'
        )->withTimestamps();
    }

    public function dailyReports()
    {
        return $this->hasMany(
            DailyReport::class,
            'class_id',
            'id'
        );
    }
}
