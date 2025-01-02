<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, HasRoles, Notifiable;

    protected $guard_name = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'mobile',
        'address',
        'banking_number',
        'state_id',
        'township_id',
        'is_otp_code_required',
        'otp_code',
        'balance',
    ];

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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_otp_code_required' => 'boolean',
        ];
    }

    public function canAccessPanel(\Filament\Panel $panel): bool
    {
        return $this->is_active;
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function township(): BelongsTo
    {
        return $this->belongsTo(Township::class);
    }

    public function fromTransactions(): MorphMany
    {
        return $this->morphMany(Transaction::class, 'from');
    }

    public function toTransactions(): MorphMany
    {
        return $this->morphMany(Transaction::class, 'to');
    }

    public function allTransactions(): Collection
    {
        return $this->fromTransactions->merge($this->toTransactions);
    }
}
