<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Meal extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [

        'id',

        'name',

        'order_no',

        'status'

    ];

    public function dailyReportMeals()
    {
        return $this->hasMany(
            DailyReportMeal::class,
            'meal_id',
            'id'
        );
    }
}
