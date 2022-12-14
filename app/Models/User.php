<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getIsAdminAttribute(): bool
    {
        return $this->role == 'admin';
    }

    public function getIsWorkerAttribute() : bool
    {
        return $this->role == 'worker';
    }

    public function getIsUserAttribute() : bool
    {
        return $this->role == 'user';
    }

    public function getIsVerifiedAttribute(): string
    {

        if (!empty($this->email_verified_at)) {
            return 'verified';
        }
        return 'unverified';
    }

    public function jobs() : HasMany
    {
        return $this->hasMany( Job::class, 'user_id', 'id');
    }
}
