<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
        'point',
        'point_proofreader',
        'status',
        'phone',
        'country',
        'google_scholars',
        'scopus',
        'orchid',
        'affiliation',
        'department',
        'cv',
        'profile_photo',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = Str::uuid();
            }
        });
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    
    // Relasi many-to-many dengan Journal
    public function journals()
    {
        return $this->belongsToMany(Journal::class, 'journal_user', 'user_id', 'journal_id')
                    ->withPivot('position', 'sort_order', 'status')
                    ->withTimestamps();
    }
    
    public function focusAndScopes()
    {
        // return $this->belongsToMany(FocusAndScope::class, 'user_focus_and_scope');
        return $this->belongsToMany(FocusAndScope::class, 'user_focus_and_scope', 'user_id', 'focus_and_scope_id');
    }
    
    // Relasi dengan Point (one-to-many)
    public function points()
    {
        return $this->hasMany(Point::class);
    }

    // relasi dengan profreader
        public function profreaders()
    {
        return $this->hasMany(Point::class);
    }

    
    // Relasi dengan PointCutOff (one-to-many)
    public function pointCutOffs()
    {
        return $this->hasMany(PointCutOff::class);
    }

    public function getProfilePhotoUrlAttribute()
    {
        return $this->profile_photo
            ? asset('storage/' . $this->profile_photo) // pastikan file tersimpan di storage/app/public
            : 'https://ui-avatars.com/api/?name=' . urlencode($this->name); // fallback
    }

    public function getAvatarUrlAttribute()
    {
        return $this->profile_photo_url;
    }

    public function hasAnyRole(array $roles): bool
    {
        return $this->roles->pluck('name')->intersect($roles)->isNotEmpty();
    }

    public function agreement(): HasOne
    {
        return $this->hasOne(Agreement::class);
    }

}