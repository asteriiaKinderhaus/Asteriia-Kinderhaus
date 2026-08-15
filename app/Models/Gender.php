<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gender extends Model
{
    use HasFactory;

    protected $table = 'genders';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'gender'
    ];

    /**
     * Gender dimiliki banyak fasilitator
     */
    public function facilitators()
    {
        return $this->hasMany(Facilitator::class);
    }

    /**
     * Gender dimiliki banyak siswa
     */
    public function students()
    {
        return $this->hasMany(
            Student::class,
            'gender_id',
            'id'
        );
    }
}
