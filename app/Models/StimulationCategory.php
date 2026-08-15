<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StimulationCategory extends Model
{
    use HasFactory;

    protected $table = 'stimulation_categories';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'name',
    ];

    public function items()
    {
        return $this->hasMany(
            StimulationItem::class,
            'category_id',
            'id'
        );
    }
}
