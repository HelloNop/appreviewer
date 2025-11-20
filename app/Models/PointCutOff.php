<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PointCutOff extends Model
{
    protected $fillable = [
        'user_id',
        'total',
        'reason',
        'type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
