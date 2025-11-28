<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FocusAndScope extends Model
{
    protected $fillable = ['name'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function journals()
    {
        return $this->belongsToMany(Journal::class);
    }
    
}
