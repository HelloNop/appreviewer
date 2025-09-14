<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
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
        'status',
        'phone',
        'country',
        'google_scholars',
        'scopus',
        'affiliation',
        'department',
        'cv',
        'profile_photo',
    ];

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
                    ->withPivot('role', 'is_owner') // jika ada kolom tambahan di pivot
                    ->withTimestamps();
    }
    
    // Relasi dengan FocusAndScope (many-to-many)
    public function focusAndScopes()
    {
        return $this->belongsToMany(FocusAndScope::class, 'user_focus_and_scope');
    }
    
    // Relasi dengan Point (one-to-many)
    public function points()
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

}
