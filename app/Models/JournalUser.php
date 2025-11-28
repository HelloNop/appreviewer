<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JournalUser extends Model
{
    protected $table = 'journal_user';
    protected $fillable = ['journal_id', 'user_id', 'position', 'status', 'sort_order'];
    public $incrementing = true;

    public function journal(): BelongsTo
    {
        return $this->belongsTo(Journal::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // nomor SK
    public function getPublisherCodeAttribute()
    {
        $brand = $this->journal->publisher->brand_name ?? '';
        return explode(' ', trim($brand))[0];
    }

    public function getBulanRomawiAttribute()
    {
        $romawi = ['', 'I','II','III','IV','V','VI','VII','VIII','IX','X','XI','XII'];
        return $romawi[$this->created_at->format('n')];
    }
    
    public function getPositionCodeAttribute()
    {
        return strtoupper(substr($this->position, 0, 2));
    }

    public function getSkNumberAttribute()
    {
        $ids = $this->id;
        $userId = $this->user->id;
        $publisherCode = $this->publisher_code;
        $bulan = $this->bulan_romawi;
        $tahun = $this->created_at->format('Y');
        $positionCode = $this->position_code;

        return "{$ids}-{$publisherCode}/{$userId}/SK/{$positionCode}/{$bulan}/{$tahun}";
    }
}
