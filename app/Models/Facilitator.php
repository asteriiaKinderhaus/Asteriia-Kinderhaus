<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\SchoolClass;

class Facilitator extends Model
{
    use SoftDeletes;

    protected $table = 'facilitators';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'name',
        'birth_date',
        'address',
        'email',
        'telephone',
        'gender_id',
        'user_id',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }

    public function schoolClasses()
    {
        return $this->belongsToMany(
            SchoolClass::class,
            'facilitator_class',
            'facilitator_id',
            'class_id'
        )->withTimestamps();
    }

    public function dailyReports()
    {
        return $this->hasMany(
            DailyReport::class,
            'facilitator_id',
            'id'
        );
    }
}
