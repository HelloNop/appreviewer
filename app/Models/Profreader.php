<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profreader extends Model
{
        protected $fillable = [
        'user_id',
        'journal_id',
        'Judul_Artikel',
        'cut_off_date',
        'is_cutoff'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function journal()
    {
        return $this->belongsTo(Journal::class);
    }

    // increment point when create
    protected static function booted()
    {
        static::created(function ($point) {
            $user = $point->user;
            $user->increment('point_proofreader');
        });
    }
}
