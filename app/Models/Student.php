<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\ParentModel;
use App\Models\Gender;
use App\Models\SchoolClass;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'students';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'nis',
        'name',
        'nickname',
        'birth_place',
        'birth_date',
        'gender_id',
        'class_id',
        'parent_id',
        'photo',
        'status',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'status' => 'boolean',
    ];

    public function parent()
    {
        return $this->belongsTo(
            ParentModel::class,
            'parent_id',
            'id'
        );
    }

    public function gender()
    {
        return $this->belongsTo(
            Gender::class,
            'gender_id',
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

    public function dailyReports()
    {
        return $this->hasMany(
            DailyReport::class,
            'student_id',
            'id'
        );
    }
}
