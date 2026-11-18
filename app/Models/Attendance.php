<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    protected $table = 'attendances';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'student_id',
        'facilitator_id',
        'attendance_date',
        'status',
        'notes',
    ];

    protected $casts = [
        'attendance_date' => 'date',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function facilitator(): BelongsTo
    {
        return $this->belongsTo(Facilitator::class);
    }
}
