<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JournalUser extends Model
{
    protected $table = 'journal_user';
    protected $fillable = ['journal_id', 'user_id', 'position', 'status', 'sort_order'];
    public $incrementing = true; // wajib untuk Repeater di Filament

    public function journal(): BelongsTo
    {
        return $this->belongsTo(Journal::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
