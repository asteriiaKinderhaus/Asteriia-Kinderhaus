<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SelfHelp extends Model
{
    use SoftDeletes;

    protected $table = 'self_helps';

    protected $fillable = [
        'id',
        'name',
        'order_no',
        'status',
    ];

    public $incrementing = false;

    protected $keyType = 'string';
}
