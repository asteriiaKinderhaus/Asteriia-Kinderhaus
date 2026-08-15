<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassModel extends Model
{
    use SoftDeletes;

    protected $table = 'school_classes';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable =
    [
        'id',
        'name',
        'capacity',
        'status',
    ];

    protected $casts =
    [
        'status' => 'boolean',
    ];

    /**
     * Relasi ke student
     */

    public function student()
    {
        return $this->hasMany(
            Student::class,
            'student_id',
            'id'
        );
    }

    /**
     * Relasi ke Fasilitator
     */

    public function facilitator() {}
}
