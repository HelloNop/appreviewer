<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Journal extends Model
{
    protected $fillable = [
        'title', 
        'singkatan',
        'publisher',
        'url',
        'certificate',
        'publisher_id',
    ];

    public function focusAndScopes()
    {
        return $this->belongsToMany(FocusAndScope::class, 'journal_focus_and_scope');
    }



    public function journalEditors(): HasMany
    {
        return $this->hasMany(JournalUser::class)
            ->whereNotIn('position', ['Reviewer', 'International Reviewer', 'Team Reviewer'])
            ->orderBy('sort_order', 'asc');
    }

    public function journalReviewers(): HasMany
    {
        return $this->hasMany(JournalUser::class)
            ->whereIn('position', ['Reviewer', 'International Reviewer', 'Team Reviewer'])
            ->orderBy('sort_order', 'asc');
    }


    public function publisher() {
        return $this->belongsTo(Publisher::class);
    }




}