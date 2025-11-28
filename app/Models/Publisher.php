<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    protected $fillable = [
        'name',
        'brand_name',
        'banner',
        'signature',
        'director'
    ];

    public function journals() {
        return $this->hasMany(Journal::class);
    }
}
