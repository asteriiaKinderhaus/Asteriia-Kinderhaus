<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacilitatorStudent extends Model
{
    protected $table = 'facilitator_student';
    public $incrementing = false;
    protected $primaryKey = null;
    protected $fillable = [
        'facilitator_id',
        'student_id',
    ];

    public function facilitator()
    {
        return $this->belongsTo(
            Facilitator::class,
            'facilitator_id',
            'id'
        );
    }

    public function student()
    {
        return $this->belongsTo(
            Student::class,
            'student_id',
            'id'
        );
    }
}
