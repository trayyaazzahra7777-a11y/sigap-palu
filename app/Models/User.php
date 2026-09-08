<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isOperator(): bool
    {
        return $this->role === 'operator';
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    public function dokumentasiKejadian(): HasMany
    {
        return $this->hasMany(DokumentasiKejadian::class, 'id_user', 'id');
    }

    public function simulasi(): HasMany
    {
        return $this->hasMany(Simulasi::class, 'id_user', 'id');
    }

    public function logData(): HasMany
    {
        return $this->hasMany(LogData::class, 'id_user', 'id');
    }
}
